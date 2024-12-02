<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Club;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateClub extends Component
{
    public $name;
    public $address;
    public $phone;
    public $email;
    public $cif;

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'cif' => 'nullable|string|max:20'
    ];

    public function save()
    {
        $validated = $this->validate();
        
        $club = Club::create($validated);
        
        User::where('id', Auth::id())->update(['club_id' => $club->id]);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.create-club');
    }
}