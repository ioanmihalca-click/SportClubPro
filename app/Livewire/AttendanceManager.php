<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class AttendanceManager extends Component
{
    public $selectedDate;
    public $selectedGroup;
    public $attendees = [];

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function updatedSelectedGroup($value)
    {
        if ($value) {
            // Preîncarcă prezențele existente pentru data și grupa selectată
            $existingAttendances = Attendance::where('date', $this->selectedDate)
                ->where('group_id', $value)
                ->pluck('member_id')
                ->toArray();

            // Pregătește array-ul de prezențe
            $this->attendees = Member::where('group_id', $value)
                ->where('active', true)
                ->get()
                ->mapWithKeys(function ($member) use ($existingAttendances) {
                    return [$member->id => in_array($member->id, $existingAttendances)];
                })
                ->toArray();
        }
    }

    public function updatedSelectedDate($value)
    {
        if ($this->selectedGroup) {
            $this->updatedSelectedGroup($this->selectedGroup);
        }
    }

    public function saveAttendance()
    {
        $this->validate([
            'selectedDate' => 'required|date',
            'selectedGroup' => 'required|exists:groups,id'
        ]);

        // Șterge prezențele existente pentru această zi și grupă
        Attendance::where('date', $this->selectedDate)
            ->where('group_id', $this->selectedGroup)
            ->delete();

        // Salvează noile prezențe
        foreach ($this->attendees as $memberId => $isPresent) {
            if ($isPresent) {
                Attendance::create([
                    'member_id' => $memberId,
                    'group_id' => $this->selectedGroup,
                    'date' => $this->selectedDate
                ]);
            }
        }

        session()->flash('message', 'Prezențele au fost salvate cu succes!');
    }

    public function render()
    {
        return view('livewire.attendance-manager', [
            'groups' => Auth::user()->club->groups,
            'members' => $this->selectedGroup ? Member::where('group_id', $this->selectedGroup)
                ->where('active', true)
                ->get() : collect([])
        ]);
    }
}