<?php

namespace App\Livewire;

use Livewire\Component;

class TruckModal extends Component
{
    public $selectedOption;
    public $showModal = false;

    protected $listeners = ['openModal' => 'show'];

    public function show($option)
    {
        $this->selectedOption = $option;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.truck-modal');
    }
}
