<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function getStats()
    {
        $club_id = Auth::user()->club_id;

        return [
            'total_members' => Member::where('club_id', $club_id)->where('active', true)->count(),
            'today_payments' => Payment::whereHas('member', function($query) use ($club_id) {
                $query->where('club_id', $club_id);
            })->whereDate('payment_date', today())->count(),
            'upcoming_events' => Event::where('club_id', $club_id)
                ->where('date', '>=', today())
                ->orderBy('date')
                ->take(5)
                ->get(),
        ];
    }

    public function render()
    {
        $stats = $this->getStats();
        
        return view('livewire.dashboard', [
            'stats' => $stats
        ]);
    }
}