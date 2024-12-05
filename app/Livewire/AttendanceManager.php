<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceManager extends Component
{
    public $selectedDate;
    public $selectedGroup;
    public $attendees = [];
    public $activeTab = 'mark';
    
    // Pentru vizualizare
    public $startDate;
    public $endDate;
    public $selectedMember;

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->resetAttendees();
    }

    public function resetAttendees()
    {
        if ($this->selectedGroup) {
            $existingAttendances = Attendance::where('date', $this->selectedDate)
                ->where('group_id', $this->selectedGroup)
                ->pluck('member_id')
                ->toArray();

            $this->attendees = Member::where('group_id', $this->selectedGroup)
                ->where('active', true)
                ->get()
                ->mapWithKeys(function ($member) use ($existingAttendances) {
                    return [$member->id => in_array($member->id, $existingAttendances)];
                })
                ->toArray();
        }
    }

    public function updatedSelectedGroup($value)
    {
        $this->resetAttendees();
    }

    public function updatedSelectedDate($value)
    {
        $this->resetAttendees();
    }

    public function setActiveTab($tab)
    {
        // Modifică ordinea operațiilor
        $this->activeTab = $tab;
        
        if ($tab === 'mark') {
            $this->selectedDate = now()->format('Y-m-d');
        } else {
            $this->startDate = now()->startOfMonth()->format('Y-m-d');
            $this->endDate = now()->endOfMonth()->format('Y-m-d');
        }
        
        // Resetează după ce ai setat valorile necesare
        $this->reset(['selectedGroup', 'selectedMember', 'attendees']);
        
        if ($tab === 'mark') {
            $this->resetAttendees();
        }
    }

    public function getAttendanceStats()
    {
        $query = Attendance::query()
            ->when($this->selectedGroup, function ($query) {
                $query->where('group_id', $this->selectedGroup);
            })
            ->when($this->selectedMember, function ($query) {
                $query->where('member_id', $this->selectedMember);
            })
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        $attendances = $query->get()
            ->groupBy('member_id');

        return Member::where('club_id', Auth::user()->club_id)
            ->when($this->selectedGroup, function ($query) {
                $query->where('group_id', $this->selectedGroup);
            })
            ->when($this->selectedMember, function ($query) {
                $query->where('id', $this->selectedMember);
            })
            ->where('active', true)
            ->get()
            ->map(function ($member) use ($attendances) {
                $memberAttendances = $attendances[$member->id] ?? collect([]);
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'group' => $member->group ? $member->group->name : 'Fără grupă',
                    'total_attendances' => $memberAttendances->count(),
                    'attendance_dates' => $memberAttendances->pluck('date')->map(function($date) {
                        return Carbon::parse($date)->format('Y-m-d');
                    })->toArray()
                ];
            });
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
    // Adaugă verificări pentru a evita erorile null
    $user = Auth::user();
    $club = $user->club;

    if (!$club) {
        return view('livewire.attendance-manager', [
            'groups' => collect([]),
            'members' => collect([]),
            'allMembers' => collect([]),
            'attendanceStats' => null
        ]);
    }

    return view('livewire.attendance-manager', [
        'groups' => $club->groups,
        'members' => $this->selectedGroup 
            ? Member::where('group_id', $this->selectedGroup)
                ->where('active', true)
                ->get() 
            : collect([]),
        'allMembers' => Member::where('club_id', $club->id)
            ->where('active', true)
            ->orderBy('name')
            ->get(),
        'attendanceStats' => $this->activeTab === 'view' ? $this->getAttendanceStats() : null
    ]);
}
}