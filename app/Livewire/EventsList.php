<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class EventsList extends Component
{
    use WithPagination;

    public $search = '';
    public $showPast = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'showPast' => ['except' => false]
    ];

    public function getEvents()
    {
        return Event::query()
            ->where('club_id', Auth::user()->club_id)
            ->when(!$this->showPast, fn($query) => $query->where('date', '>=', now()->startOfDay()))
            ->when($this->search, fn($query) => 
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('type', 'like', "%{$this->search}%")
            )
            ->orderBy('date')
            ->paginate(10);
    }

    public function deleteEvent($eventId)
    {
        $event = Event::where('id', $eventId)
            ->where('club_id', Auth::user()->club_id)
            ->first();

        if ($event) {
            $event->delete();
            session()->flash('message', 'Evenimentul a fost șters cu succes!');
        }
    }

    public function render()
    {
        return view('livewire.events-list', [
            'events' => $this->getEvents()
        ]);
    }
}

