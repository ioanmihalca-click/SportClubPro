<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupsList extends Component
{
    public $name;
    public $description;
    public $editingGroupId = null;
    public $editingName;
    public $editingDescription;

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable'
    ];

    public function save()
    {
        $this->validate();

        Group::create([
            'club_id' => Auth::user()->club_id,
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->reset(['name', 'description']);
        session()->flash('message', 'Grupa a fost adăugată cu succes!');
    }

    public function edit($groupId)
    {
        $group = Group::find($groupId);
        $this->editingGroupId = $groupId;
        $this->editingName = $group->name;
        $this->editingDescription = $group->description;
    }

    public function update()
    {
        $this->validate([
            'editingName' => 'required|min:3',
            'editingDescription' => 'nullable'
        ]);

        $group = Group::where('id', $this->editingGroupId)
            ->where('club_id', Auth::user()->club_id)
            ->first();

        if (!$group) {
            session()->flash('error', 'Grupa nu a fost găsită!');
            return;
        }

        $group->update([
            'name' => $this->editingName,
            'description' => $this->editingDescription
        ]);

        $this->reset(['editingGroupId', 'editingName', 'editingDescription']);
        session()->flash('message', 'Grupa a fost actualizată cu succes!');
    }

    public function delete($groupId)
    {
        $group = Group::where('id', $groupId)
            ->where('club_id', Auth::user()->club_id)
            ->first();

        if (!$group) {
            session()->flash('error', 'Grupa nu a fost găsită!');
            return;
        }

        // Verificăm dacă grupa are membri
        if ($group->members()->count() > 0) {
            session()->flash('error', 'Nu puteți șterge o grupă care are membri asociați!');
            return;
        }

        $group->delete();
        session()->flash('message', 'Grupa a fost ștearsă cu succes!');
    }

    public function render()
    {
        return view('livewire.groups-list', [
            'groups' => Group::where('club_id', Auth::user()->club_id)->get()
        ]);
    }
}
