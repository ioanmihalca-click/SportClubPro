<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportService
{
    public function generateMembersList($clubId)
    {
        $members = Member::where('club_id', $clubId)
            ->with(['group', 'feeType'])
            ->get();

        $pdf = PDF::loadView('reports.members-list', [
            'members' => $members,
            'generatedAt' => now(),
            'clubName' => Auth::user()->club->name
        ]);

        return $pdf->download('lista-membri.pdf');
    }

    public function generateFinancialReport($clubId, $month, $year)
    {
        $payments = Payment::whereHas('member', function($query) use ($clubId) {
                $query->where('club_id', $clubId);
            })
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->with(['member', 'feeType'])
            ->get();

        $totalAmount = $payments->sum('amount');
        
        $pdf = PDF::loadView('reports.financial', [
            'payments' => $payments,
            'totalAmount' => $totalAmount,
            'month' => Carbon::createFromDate($year, $month, 1)->format('F Y'),
            'generatedAt' => now(),
            'clubName' => Auth::user()->club->name
        ]);

        return $pdf->download('raport-financiar.pdf');
    }

    public function generateAttendanceReport($clubId, $startDate, $endDate, $groupId = null)
    {
        $attendances = Attendance::whereHas('member', function($query) use ($clubId) {
                $query->where('club_id', $clubId);
            })
            ->when($groupId, function($query) use ($groupId) {
                $query->where('group_id', $groupId);
            })
            ->whereBetween('date', [$startDate, $endDate])
            ->with(['member', 'group'])
            ->get()
            ->groupBy('date');

        $pdf = PDF::loadView('reports.attendance', [
            'attendances' => $attendances,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now(),
            'clubName' => Auth::user()->club->name
        ]);

        return $pdf->download('raport-prezente.pdf');
    }

    public function generateEventResults($eventId)
    {
        $event = Event::with(['participants' => function($query) {
                $query->orderBy('name');
            }])->findOrFail($eventId);

        $pdf = PDF::loadView('reports.event-results', [
            'event' => $event,
            'generatedAt' => now(),
            'clubName' => Auth::user()->club->name
        ]);

        return $pdf->download('rezultate-eveniment.pdf');
    }
}