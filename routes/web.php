<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

// Members Routes
Route::prefix('members')->group(function () {
    Route::get('/', function () {
        return view('members.index');
    })->name('members.index');

    Route::get('/create', function () {
        return view('members.create');
    })->name('members.create');

    Route::get('/{member}/edit', function ($member) {
        return view('members.edit', ['memberId' => $member]);
    })->name('members.edit');
});

//Groupe
Route::get('/groups', function () {
    return view('groups.index');
})->name('groups.index');

//Tipuri de Cotizatii
Route::get('/fee-types', function () {
    return view('fee-types.index');
})->name('fee-types.index');

//Prezente
Route::get('/attendance', function () {
    return view('attendance.index');
})->name('attendance.index');

//Events
Route::get('/events', function () {
    return view('events.index');
})->name('events.index');

Route::get('/events/create', function () {
    return view('events.create');
})->name('events.create');

Route::get('/events/{event}/edit', function ($event) {
    return view('events.edit', ['eventId' => $event]);
})->name('events.edit');

Route::get('/events/{event}/participants', function (App\Models\Event $event) {
    return view('events.participants', ['event' => $event]);
})->name('events.participants');

//Rapoarte pdf
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/members', [ReportController::class, 'membersList'])->name('members');
    Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
    Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
    Route::get('/event/{event}/results', [ReportController::class, 'eventResults'])->name('event-results');
});

});
