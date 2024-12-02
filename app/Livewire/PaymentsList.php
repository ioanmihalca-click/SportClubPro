<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Member;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PaymentsList extends Component
{
    use WithPagination;

    public $search = '';
    public $memberId;
    public $feeTypeId;
    public $amount;
    public $paymentDate;
    public $notes;

    public function rules()
    {
        return [
            'memberId' => 'required|exists:members,id',
            'feeTypeId' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'paymentDate' => 'required|date',
            'notes' => 'nullable|string'
        ];
    }

    public function mount()
    {
        $this->paymentDate = now()->format('Y-m-d');
    }

    public function savePayment()
    {
        $validated = $this->validate();
        
        Payment::create([
            'member_id' => $validated['memberId'],
            'fee_type_id' => $validated['feeTypeId'],
            'amount' => $validated['amount'],
            'payment_date' => $validated['paymentDate'],
            'notes' => $validated['notes']
        ]);

        session()->flash('message', 'Plata a fost înregistrată cu succes!');
        
        $this->reset(['memberId', 'amount', 'notes']);
        $this->dispatch('paymentAdded');
    }

    public function deletePayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->delete();
        
        session()->flash('message', 'Plata a fost ștearsă cu succes!');
    }

    public function getPayments()
    {
        return Payment::query()
            ->whereHas('member', function($query) {
                $query->where('club_id', Auth::user()->club_id);
            })
            ->with(['member', 'feeType'])
            ->when($this->search, function($query) {
                $query->whereHas('member', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->latest('payment_date')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.payments-list', [
            'payments' => $this->getPayments(),
            'members' => Member::where('club_id', Auth::user()->club_id)
                              ->where('active', true)
                              ->orderBy('name')
                              ->get(),
            'feeTypes' => Auth::user()->club->feeTypes
        ]);
    }
}