<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'club_id',
        'name',
        'description'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}