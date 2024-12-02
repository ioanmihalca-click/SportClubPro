<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventForm extends Component
{
    public $eventId;
    public $name;
    public $date;
    public $type;
    public $details;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|min:3',
        'date' => 'required|date|after_or_equal:today',
        'type' => 'required',
        'details' => 'nullable'
    ];

    public function mount($eventId = null)
    {
        if ($eventId) {
            $this->isEdit = true;
            $this->eventId = $eventId;
            $event = Event::findOrFail($eventId);
            
            $this->name = $event->name;
            $this->date = $event->date->format('Y-m-d');
            $this->type = $event->type;
            $this->details = $event->details;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            Event::where('id', $this->eventId)
                ->where('club_id', Auth::user()->club_id)
                ->update([
                    'name' => $this->name,
                    'date' => $this->date,
                    'type' => $this->type,
                    'details' => $this->details
                ]);
        } else {
            Event::create([
                'club_id' => Auth::user()->club_id,
                'name' => $this->name,
                'date' => $this->date,
                'type' => $this->type,
                'details' => $this->details
            ]);
        }

        session()->flash('message', 'Evenimentul a fost ' . ($this->isEdit ? 'actualizat' : 'adăugat') . ' cu succes!');
        return redirect()->route('events.index');
    }

    public function render()
    {
        return view('livewire.event-form', [
            'eventTypes' => [
                'competition' => 'Competiție',
                'exam' => 'Examen',
                'seminar' => 'Seminar',
                'other' => 'Altele'
            ]
        ]);
    }
}