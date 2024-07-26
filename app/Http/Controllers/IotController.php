<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use carbon\CarbonPeriod;

class IotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $producion = DB::connection('iotmoi')->table('ProduccionYKM')->where('')->get();

        $formattedDate = Carbon::now()->setTime(20, 6)->format('Y-m-d H:i');
        $seleccionturno = Carbon::now()->format('Y-m-d H:i');

        $matution = [];
        $nocturno = [];
        $data = DB::connection('ultateck')->select('EXEC web_dashboard_actual_trf2500', []);
        // $contador=DB::connection('ultateck')->select('Historial_TRF2500', []);
        $collection = collect($data);
        // Si necesitas agrupar los resultados por hora y sumar las piezas
        $groupedResults = $collection->groupBy(function ($item) {
            return date('H', strtotime($item->fecha));
        })->map(function ($hourlyData) {
            return [
                'total_piezas' => $hourlyData->sum('produccion'),
                'hora' => $hourlyData->max('fecha'),
            ];
        });
        $data = [];
        $dataall = [];
        $turnoant = '';
        $turnoact = '';
        $hoy = Carbon::now()->format('d/m/Y');
        $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');
        // $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s','25/07/2024 21:00:00');
        $fechaConHoraplan = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');
        //  $fechaConHoraplan = Carbon::createFromFormat('d/m/Y H:i:s', '25/07/2024 21:00:00');

        $PLANANT = 14000;
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


        $year = 2024;
        $month = 7;

        // Crear una fecha inicial y una fecha final para el mes especificado
        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Crear un período de fechas desde el inicio hasta el final del mes
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth);
        $dias = [];
        $datadia = [];
        foreach ($period as $date) {

            $nextDay = $date->copy()->addDay();

            $sql = "
            WITH CustomerCTE AS (
                SELECT
                    numeroContenedor_NumeroParteActual,
                    MIN(eventoTRF_Id) AS evmin,
                    MAX(eventoTRF_Id) AS maxev,
                    MAX(contadorTotal_ProduccionReal) AS prod,
                    MIN(contadorTotal_ProduccionReal) AS prodm,
                    MAX(numeroContenedor_NombreParteActual) AS produ,
                    MIN(fecha) AS inicio,
                    MAX(fecha) AS fin
                FROM [YKMPrensas].[dbo].[Historial_TRF2500]
                WHERE (fecha > '" . $date->format('d/m/Y') . " 08:00:00' AND fecha < '" .  $nextDay->format('d/m/Y') . " 08:00:00')
                    AND contadorTotal_ProduccionReal IS NOT NULL
                    AND contadorTotal_ProduccionReal != 0
                    AND numeroContenedor_NombreParteActual != ''
                    AND numeroContenedor_NumeroParteActual IS NOT NULL
                GROUP BY numeroContenedor_NumeroParteActual
            )
            SELECT SUM(contadorTotal_ProduccionReal) AS produc
            FROM [YKMPrensas].[dbo].[Historial_TRF2500]
            WHERE eventoTRF_Id IN (SELECT maxev FROM CustomerCTE);
            ";

            $result = DB::connection('ultateck')->select($sql);
            $golpes = $result[0];


            $datadia = [
                "golpes" => $golpes->produc,
                "diames" => $date->format('d/m/Y')

            ];
            array_push($dias,  $datadia);
        }
        return view('IOT.charts', compact('dataall', 'turnoant', 'turnoact', 'dias'));
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
