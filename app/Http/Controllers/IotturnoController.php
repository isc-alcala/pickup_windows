<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IotturnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getdata()
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
        $labels = $dataall->pluck('hora')->toArray();
        $produccion = $dataall->pluck('total_piezas')->toArray();
        $lineData = $dataall->pluck('plan')->toArray();
        $dif = $dataall->pluck('dif')->toArray();

        return response()->json([
            'labels' => $labels,
            'produccion' => $produccion,
            'lineData' => $lineData,
            'dif' => $dif,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
