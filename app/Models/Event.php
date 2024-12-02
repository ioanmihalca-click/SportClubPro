<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'club_id',
        'name',
        'date',
        'type',
        'details'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Member::class, 'event_participants')
            ->withPivot('result')
            ->withTimestamps();
    }
}