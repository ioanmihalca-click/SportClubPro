<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberForm extends Component
{
    public Member $member;
    public $isEdit = false;

    protected $rules = [
        'member.name' => 'required|min:3',
        'member.email' => 'nullable|email',
        'member.phone' => 'nullable',
        'member.birth_date' => 'nullable|date',
        'member.address' => 'nullable',
        'member.medical_notes' => 'nullable',
        'member.group_id' => 'nullable|exists:groups,id',
        'member.fee_type_id' => 'nullable|exists:fee_types,id'
    ];

    public function mount($memberId = null)
    {
        if ($memberId) {
            $this->member = Member::findOrFail($memberId);
            $this->isEdit = true;
        } else {
            $this->member = new Member();
            $this->member->club_id = Auth::user()->club_id;
            $this->member->active = true;
        }
    }

    public function save()
    {
        $this->validate();
        $this->member->save();
        
        $message = $this->isEdit ? 'Membru actualizat cu succes!' : 'Membru adăugat cu succes!';
        session()->flash('success', $message);
        
        $this->emit('memberUpdated');
        
        if (!$this->isEdit) {
            return redirect()->route('members.index');
        }
    }

    public function render()
    {
        return view('livewire.member-form', [
            'groups' => Auth::user()->club->groups,
            'feeTypes' => Auth::user()->club->feeTypes
        ]);
    }
}