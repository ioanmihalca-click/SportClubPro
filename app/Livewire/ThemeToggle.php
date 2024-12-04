<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public $darkMode = true;

    public function mount()
    {
        // Încercăm să obținem tema din localStorage
        $this->darkMode = true; 
    }

    public function toggleTheme()
    {
        $this->darkMode = !$this->darkMode;
        $this->dispatch('theme-changed', ['darkMode' => $this->darkMode]);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}