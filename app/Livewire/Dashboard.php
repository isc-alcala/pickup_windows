<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Truck;
class Dashboard extends Component
{
    public $isModalOpen = true;
    public $selectedTruck;

    protected $listeners = [
        'refreshTrucks' => '$refresh',
        'openModal' => 'openModal',
    ];

    public function openModal($truckId)
    {
        $this->selectedTruck = Dashboard::find($truckId);
        $this->isModalOpen = false;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedTruck = null;
    }

    public function render()
    {
        $trucks = truck::with(['relaciones.cliente', 'relaciones.contactoDirecto', 'relaciones.carrier', 'relaciones.rutas','latestbitcora.estatus'])->Paginate(5);

        return view('livewire.dashboard', [
            'trucks' =>$trucks
        ]);
    }
}
