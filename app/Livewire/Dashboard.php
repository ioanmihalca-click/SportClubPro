<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function getStats()
    {
        $club_id = Auth::user()->club_id;

        // Obține datele pentru graficul de plăți lunare (ultimele 6 luni)
        $monthlyPayments = Payment::whereHas('member', function ($query) use ($club_id) {
            $query->where('club_id', $club_id);
        })
            ->where('payment_date', '>=', now()->subMonths(6))
            ->select(
                DB::raw('sum(amount) as total'),
                DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $paymentsData = [
            'labels' => $monthlyPayments->pluck('month')->map(function ($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('F Y');
            })->toArray(),
            'data' => $monthlyPayments->pluck('total')->toArray()
        ];

        // Înlocuim datele pentru prezențe cu evoluția membrilor (ultimele 6 luni)
        $membersEvolution = Member::where('club_id', $club_id)
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $membersData = [
            'labels' => $membersEvolution->pluck('month')->map(function ($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('F Y');
            })->toArray(),
            'data' => $membersEvolution->pluck('total')->toArray()
        ];

        // Obținem membrii cu restanțe cu detalii
        $unpaidMembers = Member::where('club_id', $club_id)
            ->where('active', true)
            ->whereDoesntHave('payments', function ($query) {
                $query->whereYear('payment_date', now()->year)
                    ->whereMonth('payment_date', now()->month);
            })
            ->with(['group', 'feeType', 'payments' => function ($query) {
                $query->latest('payment_date')->limit(1);
            }])
            ->get()
            ->map(function ($member) {
                $lastPayment = $member->payments->first();
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'group' => $member->group ? $member->group->name : 'Fără grupă',
                    'fee_type' => $member->feeType ? $member->feeType->name : 'Nespecificat',
                    'last_payment_date' => $lastPayment ? $lastPayment->payment_date->format('d.m.Y') : 'Nicio plată',
                    'last_payment_amount' => $lastPayment ? $lastPayment->amount : 0,
                    'phone' => $member->phone ?? 'Nespecificat',
                    'email' => $member->email ?? 'Nespecificat'
                ];
            })->values()->toArray();

        return [
            'total_members' => Member::where('club_id', $club_id)
                ->where('active', true)
                ->count(),

            'today_payments' => Payment::whereHas('member', function ($query) use ($club_id) {
                $query->where('club_id', $club_id);
            })->whereDate('payment_date', today())->count(),

            'upcoming_events' => Event::where('club_id', $club_id)
                ->where('date', '>=', today())
                ->orderBy('date')
                ->take(5)
                ->get(),

            'monthly_payments' => Payment::whereHas('member', function ($query) use ($club_id) {
                $query->where('club_id', $club_id);
            })
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', now()->month)
                ->sum('amount'),

            'today_attendances' => Attendance::whereHas('member', function ($query) use ($club_id) {
                $query->where('club_id', $club_id);
            })->whereDate('date', today())->count(),

            'unpaid_members_count' => count($unpaidMembers),
            'unpaid_members_details' => $unpaidMembers,

            'charts' => [
                'payments' => $paymentsData,
                'members' => $membersData
            ]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'stats' => $this->getStats()
        ]);
    }
}
