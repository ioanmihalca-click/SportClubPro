<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function membersList()
    {
        return $this->reportService->generateMembersList(Auth::user()->club_id);
    }

    public function financial(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2000'
        ]);

        return $this->reportService->generateFinancialReport(
            Auth::user()->club_id,
            $request->month,
            $request->year
        );
    }

    public function attendance(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'group_id' => 'nullable|exists:groups,id'
        ]);

        return $this->reportService->generateAttendanceReport(
            Auth::user()->club_id,
            $request->start_date,
            $request->end_date,
            $request->group_id
        );
    }

    public function eventResults($eventId)
    {
        return $this->reportService->generateEventResults($eventId);
    }
}