<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RefreshDiv extends Component
{
    public $time;

    public function mount()
    {
        $this->updateTime();
    }

    public function updateTime()
    {

        $contadorp = DB::connection('ultateck')->table('Historial_TRF2500')->orderby('fecha','desc')->first();

        if ($contadorp) {
            $this->time = $contadorp->fecha;
        } else {
            $this->time = 'No data found';
        }
    }

    public function render()
    {
        return view('livewire.refresh-div');
    }
}
