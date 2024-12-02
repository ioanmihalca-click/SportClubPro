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
    
    // Pentru ascultare real-time
    protected $listeners = ['memberUpdated' => '$refresh'];

    // Query string parameters pentru păstrarea filtrelor în URL
    protected $queryString = [
        'search' => ['except' => ''],
        'activeFilter' => ['except' => 'all'],
        'groupFilter' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getMembers()
    {
        return Member::query()
            ->where('club_id', Auth::user()->club_id)
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%')
                      ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->activeFilter !== 'all', function ($query) {
                $query->where('active', $this->activeFilter === 'active');
            })
            ->when($this->groupFilter, function ($query) {
                $query->where('group_id', $this->groupFilter);
            })
            ->with(['group', 'feeType'])
            ->orderBy('name')
            ->paginate(10);
    }

    public function toggleStatus($memberId)
    {
        $member = Member::find($memberId);
        $member->update(['active' => !$member->active]);
        $this->emit('memberUpdated');
    }

    public function render()
    {
        return view('livewire.members-list', [
            'members' => $this->getMembers(),
            'groups' => Auth::user()->club->groups
        ]);
    }
}