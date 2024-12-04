<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($club) {
            DB::transaction(function() use ($club) {
                // Mai întâi ștergem prezențele
                $club->members->each(function ($member) {
                    $member->attendances()->delete();
                });

                // Ștergem plățile
                $club->members->each(function ($member) {
                    $member->payments()->delete();
                });

                // Ștergem relațiile dintre membri și evenimente (event_participants)
                $club->members->each(function ($member) {
                    $member->events()->detach();
                });

                // Acum putem șterge membrii
                $club->members()->delete();

                // Ștergem grupurile
                $club->groups()->delete();

                // Ștergem tipurile de taxe
                $club->feeTypes()->delete();

                // Ștergem evenimentele
                $club->events()->delete();

                // Actualizăm utilizatorii asociați cu acest club
                $club->users()->update(['club_id' => null]);
            });
        });
    }

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