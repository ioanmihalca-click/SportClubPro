<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'club_id',
        'name',
        'email',
        'phone',
        'birth_date',
        'address',
        'medical_notes',
        'active',
        'group_id',
        'fee_type_id'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'active' => 'boolean'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_participants')
            ->withPivot('result')
            ->withTimestamps();
    }
}