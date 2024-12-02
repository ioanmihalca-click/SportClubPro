<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $birth_date;
    public $address;
    public $medical_notes;
    public $group_id;
    public $fee_type_id;
    public $active = true;

    public $isEdit = false;
    public $memberId;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'nullable|email',
        'phone' => 'nullable',
        'birth_date' => 'nullable|date',
        'address' => 'nullable',
        'medical_notes' => 'nullable',
        'group_id' => 'nullable|exists:groups,id',
        'fee_type_id' => 'nullable|exists:fee_types,id'
    ];

    public function mount($memberId = null)
    {
        if ($memberId) {
            $this->isEdit = true;
            $this->memberId = $memberId;
            $member = Member::findOrFail($memberId);
            
            $this->name = $member->name;
            $this->email = $member->email;
            $this->phone = $member->phone;
            $this->birth_date = $member->birth_date;
            $this->address = $member->address;
            $this->medical_notes = $member->medical_notes;
            $this->group_id = $member->group_id;
            $this->fee_type_id = $member->fee_type_id;
            $this->active = $member->active;
        }
    }

    public function save()
    {
        $this->validate();
        
        if ($this->isEdit) {
            $member = Member::find($this->memberId);
            $member->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'birth_date' => $this->birth_date,
                'address' => $this->address,
                'medical_notes' => $this->medical_notes,
                'group_id' => $this->group_id,
                'fee_type_id' => $this->fee_type_id,
                'active' => $this->active
            ]);
 
        } else {
            Member::create([
                'club_id' => Auth::user()->club_id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'birth_date' => $this->birth_date,
                'address' => $this->address,
                'medical_notes' => $this->medical_notes,
                'group_id' => $this->group_id,
                'fee_type_id' => $this->fee_type_id,
                'active' => $this->active
            ]);
        }
        
        session()->flash('message', $this->isEdit ? 'Membru actualizat cu succes!' : 'Membru adăugat cu succes!');
        $this->dispatch('memberUpdated');
        
        return redirect()->route('members.index');
    }

    public function render()
    {
        return view('livewire.member-form', [
            'groups' => Auth::user()->club->groups,
            'feeTypes' => Auth::user()->club->feeTypes
        ]);
    }
}