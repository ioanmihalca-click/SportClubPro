<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'cif'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function feeTypes()
    {
        return $this->hasMany(FeeType::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}