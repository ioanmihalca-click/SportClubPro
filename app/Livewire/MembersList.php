<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MembersList extends Component
{
    use WithPagination;

    public $search = '';
    public $activeFilter = 'all';
    public $groupFilter = '';
    public $showFinancialReportModal = false;
    public $reportMonth;
    public $reportYear;

    protected $listeners = ['memberUpdated' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'activeFilter' => ['except' => 'all'],
        'groupFilter' => ['except' => '']
    ];

    public function mount()
    {
        $this->reportMonth = now()->month;
        $this->reportYear = now()->year;
    }

    public function updatedSearch() 
    {
        $this->resetPage();
    }

    public function getMembers()
    {
        return Member::query()
            ->select([
                'members.id',
                'members.name',
                'members.email',
                'members.phone',
                'members.active',
                'members.group_id',
                'members.fee_type_id',
                'members.club_id'
            ])
            ->where('members.club_id', Auth::user()->club_id)
            ->with([
                'group:id,name',
                'feeType:id,name,amount'
            ])
            ->when($this->search, function ($query) {  // am eliminat $search din parametri
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->activeFilter !== 'all', function ($query) {
                $query->where('active', $this->activeFilter === 'active');
            })
            ->when($this->groupFilter, function ($query) {
                $query->where('group_id', $this->groupFilter);
            })
            ->orderBy('name')
            ->paginate(10);
    }

    public function toggleStatus($memberId)
    {
        $member = Member::find($memberId);
        $member->update(['active' => !$member->active]);
        $this->dispatch('memberUpdated');
    }

    public function deleteMember($memberId)
    {
        $member = Member::where('id', $memberId)
            ->where('club_id', Auth::user()->club_id)
            ->first();
    
        if (!$member) {
            session()->flash('error', 'Membrul nu a fost găsit!');
            return;
        }
    
        // Verificăm dacă membrul are plăți sau prezențe înregistrate
        $hasPayments = $member->payments()->count() > 0;
        $hasAttendances = $member->attendances()->count() > 0;
    
        if ($hasPayments || $hasAttendances) {
            $member->update(['active' => false]);
            $message = 'Membrul nu poate fi șters deoarece are ';
            if ($hasPayments && $hasAttendances) {
                $message .= 'istoric de plăți și prezențe';
            } elseif ($hasPayments) {
                $message .= 'istoric de plăți';
            } else {
                $message .= 'istoric de prezențe';
            }
            $message .= '. A fost marcat ca inactiv.';
            
            session()->flash('message', $message);
            return;
        }
    
        $member->delete();
        session()->flash('message', 'Membrul a fost șters cu succes!');
    }

    public function render()
    {
        // Optimizăm și încărcarea grupurilor
        $groups = Auth::user()->club->groups()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        return view('livewire.members-list', [
            'members' => $this->getMembers(),
            'groups' => $groups
        ]);
    }
}