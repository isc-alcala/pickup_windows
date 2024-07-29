<?php

namespace App\Livewire;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Refreshturno extends Component
{
    public function mount()
    {
        $this->updateTime();
    }

    public function updateTime()
    {
        $data = DB::connection('ultateck')->select('EXEC web_dashboard_actual_trf2500', []);
        $collection = collect($data);
        $groupedResults = $collection->groupBy(function ($item) {
            return date('H', strtotime($item->fecha));
        })->map(function ($hourlyData) {
            return [
                'total_piezas' => $hourlyData->sum('produccion'),
                'hora' => $hourlyData->max('fecha'),
            ];
        });
        $hoy = Carbon::now()->format('d/m/Y');
        $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');

        // $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s','25/07/2024 21:00:00');
        $fechaConHoraplan = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');
        $PLANANT = 7200;
        $PLANAct = 12000;
        $SUMD = 0;
        $SUMN = 0;
        $PLANHANT = $PLANANT / 12;
        $PLANHACT = $PLANANT / 12;
        $PLAN = 0;
        foreach ($groupedResults as $result) {

            if ($fechaConHoraplan->lte($result['hora'])) {
                $SUMN = 0;
                $SUMD += $PLANHANT;
                $PLAN = $SUMD;
            } else {
                $SUMD = 0;
                $SUMN += $PLANHACT;
                $PLAN = $SUMN;
            }

            $fechaOriginal = Carbon::parse($result['hora']);
            $fechaOriginal = Carbon::parse($result['hora']);
            $fechaFormateada = $fechaOriginal->format('d/m H');

            if ($result['hora'])

                if ($fechaConHora->eq($result['hora'])) {

                    $turnoant = $result['total_piezas'];
                } else {
                    if ($result['total_piezas'] != 0) {
                        $turnoact = $result['total_piezas'];
                    }
                }

            $rest = $result['total_piezas'] - floor($PLAN);
            if ($rest < 0) {
                $rest = $rest * -1;
            } else {
            }
            $data = [
                'hora' => $fechaFormateada,
                'total_piezas' => $result['total_piezas'],
                'plan' => floor($PLAN),
                'plan1' => floor($PLAN) + 100,
                'dif' => $rest,
            ];
            array_push($dataall, $data);
        }

    }
    public function render()
    {
        return view('livewire.refreshturno');
    }
}
