<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FeeType;
use Illuminate\Support\Facades\Auth;

class FeeTypesList extends Component
{
    public $name;
    public $amount;
    public $description;
    
    public $editingFeeTypeId = null;
    public $editingName;
    public $editingAmount;
    public $editingDescription;

    protected $rules = [
        'name' => 'required|min:3',
        'amount' => 'required|numeric|min:0',
        'description' => 'nullable'
    ];

    public function save()
    {
        $this->validate();

        FeeType::create([
            'club_id' => Auth::user()->club_id,
            'name' => $this->name,
            'amount' => $this->amount,
            'description' => $this->description
        ]);

        $this->reset(['name', 'amount', 'description']);
        session()->flash('message', 'Tipul de cotizație a fost adăugat cu succes!');
    }

    public function edit($feeTypeId)
    {
        $feeType = FeeType::where('id', $feeTypeId)
                         ->where('club_id', Auth::user()->club_id)
                         ->first();
                         
        if (!$feeType) {
            session()->flash('error', 'Tipul de cotizație nu a fost găsit!');
            return;
        }

        $this->editingFeeTypeId = $feeTypeId;
        $this->editingName = $feeType->name;
        $this->editingAmount = $feeType->amount;
        $this->editingDescription = $feeType->description;
    }

    public function update()
    {
        $this->validate([
            'editingName' => 'required|min:3',
            'editingAmount' => 'required|numeric|min:0',
            'editingDescription' => 'nullable'
        ]);

        $feeType = FeeType::where('id', $this->editingFeeTypeId)
                         ->where('club_id', Auth::user()->club_id)
                         ->first();

        if (!$feeType) {
            session()->flash('error', 'Tipul de cotizație nu a fost găsit!');
            return;
        }

        $feeType->update([
            'name' => $this->editingName,
            'amount' => $this->editingAmount,
            'description' => $this->editingDescription
        ]);

        $this->reset(['editingFeeTypeId', 'editingName', 'editingAmount', 'editingDescription']);
        session()->flash('message', 'Tipul de cotizație a fost actualizat cu succes!');
    }

    public function delete($feeTypeId)
    {
        $feeType = FeeType::where('id', $feeTypeId)
                         ->where('club_id', Auth::user()->club_id)
                         ->first();

        if (!$feeType) {
            session()->flash('error', 'Tipul de cotizație nu a fost găsit!');
            return;
        }

        // Verificăm dacă există membri care folosesc acest tip de cotizație
        if($feeType->members()->count() > 0) {
            session()->flash('error', 'Nu puteți șterge un tip de cotizație care este asociat membrilor!');
            return;
        }

        $feeType->delete();
        session()->flash('message', 'Tipul de cotizație a fost șters cu succes!');
    }

    public function render()
    {
        return view('livewire.fee-types-list', [
            'feeTypes' => FeeType::where('club_id', Auth::user()->club_id)->get()
        ]);
    }
}