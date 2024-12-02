<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class EventParticipants extends Component
{
    public $event;
    public $participants = [];
    public $results = [];
    public $search = '';

    protected $listeners = ['participantUpdated' => '$refresh'];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->loadParticipants();
    }

    public function loadParticipants()
    {
        // Încarcă participanții existenți
        $existingParticipants = $this->event->participants()
            ->pluck('result', 'member_id')
            ->toArray();

        // Setează array-ul de participanți
        $this->participants = array_fill_keys(array_keys($existingParticipants), true);
        $this->results = $existingParticipants;
    }

    public function toggleParticipant($memberId)
    {
        if (!isset($this->participants[$memberId])) {
            $this->participants[$memberId] = true;
        } else {
            unset($this->participants[$memberId]);
            unset($this->results[$memberId]);
        }
    }

    public function updateResult($memberId, $result)
    {
        $this->results[$memberId] = $result;
    }

    public function save()
    {
        // Șterge toți participanții existenți
        $this->event->participants()->detach();

        // Adaugă participanții selectați cu rezultatele lor
        foreach ($this->participants as $memberId => $value) {
            if ($value) {
                $this->event->participants()->attach($memberId, [
                    'result' => $this->results[$memberId] ?? null
                ]);
            }
        }

        session()->flash('message', 'Participanții au fost salvați cu succes!');
        $this->dispatch('participantUpdated');
    }

    public function render()
    {
        $members = Member::where('club_id', Auth::user()->club_id)
            ->where('active', true)
            ->when($this->search, function($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->get();

        return view('livewire.event-participants', [
            'members' => $members
        ]);
    }
}