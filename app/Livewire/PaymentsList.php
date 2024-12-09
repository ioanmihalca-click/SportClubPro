<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Member;
use App\Models\Group;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PaymentsList extends Component
{
    use WithPagination;

    // Proprietăți pentru adăugare plată
    public $search = '';
    public $memberId;
    public $feeTypeId;
    public $amount;
    public $paymentDate;
    public $notes;
    
    // Proprietăți pentru filtrare
    public $filterMemberId = '';
    public $filterGroupId = ''; // Adăugăm proprietatea pentru filtrul după grupă
    public $dateFrom = '';
    public $dateTo = '';

    // Proprietăți pentru căutare membru
    public $searchMember = '';
    public $filteredMembers = [];

    protected $listeners = ['paymentAdded' => '$refresh'];

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
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->endOfMonth()->format('Y-m-d');
    }

    public function updatedSearchMember()
    {
        if (strlen($this->searchMember) >= 2) {
            $this->filteredMembers = Member::where('club_id', Auth::user()->club_id)
                ->where('active', true)
                ->where('name', 'like', "%{$this->searchMember}%")
                ->orderBy('name')
                ->get();
        } else {
            $this->filteredMembers = [];
        }
    }

    public function selectMember($memberId)
    {
        $this->memberId = $memberId;
        $this->searchMember = Member::find($memberId)->name;
        $this->filteredMembers = [];
    }

    public function resetFilters()
    {
        $this->reset(['filterMemberId', 'filterGroupId', 'dateFrom', 'dateTo', 'search']); // Adăugăm filterGroupId la reset
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->endOfMonth()->format('Y-m-d');
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

        $this->reset(['memberId', 'feeTypeId', 'amount', 'notes', 'searchMember']);
        $this->paymentDate = now()->format('Y-m-d');
        $this->dispatch('paymentAdded');
    }

    public function deletePayment($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $payment->delete();
            session()->flash('message', 'Plata a fost ștearsă cu succes!');
        } catch (\Exception $e) {
            session()->flash('error', 'A apărut o eroare la ștergerea plății.');
        }
    }

    public function getTotalAmount()
    {
        return $this->getPaymentsQuery()->sum('amount');
    }

    public function getTotalPayments()
    {
        return $this->getPaymentsQuery()->count();
    }

    protected function getPaymentsQuery()
    {
        return Payment::query()
            ->whereHas('member', function ($query) {
                $query->where('club_id', Auth::user()->club_id);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('member', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterMemberId, function ($query) {
                $query->where('member_id', $this->filterMemberId);
            })
            ->when($this->filterGroupId, function ($query) { // Adăugăm filtrarea după grupă
                $query->whereHas('member', function ($q) {
                    $q->where('group_id', $this->filterGroupId);
                });
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('payment_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('payment_date', '<=', $this->dateTo);
            });
    }

    public function getPayments()
    {
        return $this->getPaymentsQuery()
            ->with(['member.group', 'feeType']) // Adăugăm eager loading pentru group
            ->latest('payment_date')
            ->paginate(10);
    }

    public function render()
    {
        $payments = $this->getPayments();
        
        return view('livewire.payments-list', [
            'payments' => $payments,
            'members' => Member::where('club_id', Auth::user()->club_id)
                ->where('active', true)
                ->orderBy('name')
                ->get(),
            'groups' => Group::where('club_id', Auth::user()->club_id) // Adăugăm grupele pentru filtru
                ->orderBy('name')
                ->get(),
            'feeTypes' => Auth::user()->club->feeTypes,
            'totalAmount' => $this->getTotalAmount(),
            'totalPayments' => $this->getTotalPayments()
        ]);
    }
}