<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MembersList extends Component
{
    use WithPagination;

    public $search = '';
    public $activeFilter = 'all'; // all, active, inactive
    public $groupFilter = '';
    public $showFinancialReportModal = false;
    public $reportMonth;
    public $reportYear;


    protected $listeners = ['memberUpdated' => '$refresh'];

    // Query string parameters pentru păstrarea filtrelor în URL
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getMembers()
    {
        return Member::query()
            ->where('club_id', Auth::user()->club_id)
            ->with(['group', 'feeType']) // eager loading pentru relații
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
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
        if ($member->payments()->count() > 0 || $member->attendances()->count() > 0) {
            $member->update(['active' => false]);
            session()->flash('message', 'Membrul a fost dezactivat deoarece are istoric de plăți sau prezențe!');
            return;
        }

        $member->delete();
        session()->flash('message', 'Membrul a fost șters cu succes!');
    }

    public function render()
    {
        return view('livewire.members-list', [
            'members' => $this->getMembers(),
            'groups' => Auth::user()->club->groups
        ]);
    }
}
