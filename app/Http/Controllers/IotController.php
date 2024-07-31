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
        $data = DB::connection('ultateck')->select('EXEC web_dashboard_actual_trf2500');

        $contadorp = DB::connection('ultateck')->table('Historial_TRF2500')->orderby('fecha', 'desc')->first();
        // dd($contadorp);
        $sql2 = 'Fecha, Turno, SUM(Plan_produccion) AS total_acumulado
        FROM Planprensas
        GROUP BY Fecha, Turno
        ORDER BY Fecha, Turno;';
        $planmes = DB::table('planprensas')->select(DB::raw('Fecha, Turno, SUM(cantidad) AS total_acumulado'))
            ->groupBy('Fecha', 'Turno')
            ->orderBy('Fecha')
            ->orderBy('Turno')
            ->get();

        // $plandia=$planmes->where('Fecha', now()->format('Y-m-d'))->sum('total_acumulado');


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



        $dataall = [];
        $turnoant = '';
        $turnoact = '';
        $hoy = Carbon::now()->format('d/m/Y');
        $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');

        // $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s','25/07/2024 21:00:00');
        $fechaConHoraplan = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');
        //  $fechaConHoraplan = Carbon::createFromFormat('d/m/Y H:i:s', '25/07/2024 21:00:00');

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
            if ($result['total_piezas'] < floor($PLAN)) {
                $rest = $rest * -1;
            } else {
                $rest = 0;
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
        $monthback = 6;

        // Crear una fecha inicial y una fecha final para el mes especificado
        $startOfMonthback = Carbon::create($year, $monthback, 1);
        $endOfMonthback = $startOfMonthback->copy()->endOfMonth();
        $mondays = [];
        $currentDay = $startOfMonthback->copy();
        while ($currentDay->lte($endOfMonthback)) {
            // Si el día es lunes, agregarlo al array
            if ($currentDay->isMonday()) {
                $mondays[] = $currentDay->toDateString();
            }
            // Avanzar al siguiente día
            $currentDay->addDay();
        }

        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();


        // Array para almacenar los lunes del mes


        // Iterar a través de cada día del mes
        $currentDay = $startOfMonth->copy();
        while ($currentDay->lte($endOfMonth)) {
            // Si el día es lunes, agregarlo al array
            if ($currentDay->isMonday()) {
                $mondays[] = $currentDay->toDateString();
            }
            // Avanzar al siguiente día
            $currentDay->addDay();
        }



        // Crear un período de fechas desde el inicio hasta el final del mes
        $planw = [
            ['fecha' => '15/07/2024', 'cantidad' => 7402],
            ['fecha' => '22/07/2024', 'cantidad' => 5786],
            ['fecha' => '08/07/2024', 'cantidad' => 19612],
            ['fecha' => '01/07/2024', 'cantidad' => 18680],
            ['fecha' => '24/06/2024', 'cantidad' => 20394],
            ['fecha' => '17/06/2024', 'cantidad' => 20686],
            ['fecha' => '10/06/2024', 'cantidad' => 17356],
            ['fecha' => '03/06/2024', 'cantidad' => 19492]

        ];
        $dias = [];
        $datadia = [];
        $length = count($mondays);
        // $fechaplan=$planw->pluck('fecha');
        foreach ($mondays as $index => $monday) {
            $currentMonday = Carbon::parse($monday);

            $nextMonday = ($index + 1 < $length) ? Carbon::parse($mondays[$index + 1]) : null;
            if ($nextMonday) {
                if ($nextMonday->lte(now())) {
                    $currentMonday = Carbon::parse($monday);
                    $fechaInicio = $currentMonday->format('d-m-Y') . ' 08:00:00';
                    $fechaFin = $nextMonday->format('d-m-Y') . ' 8:00:00';
                    $subQueryN = DB::connection('ultateck')->table('dbo.Historial_TRF2500')
                        ->select('numeroContenedor_NumeroParteActual', DB::raw('MAX(eventoTRF_Id) as maxev'))
                        ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                        ->whereNotNull('contadorTotal_ProduccionReal')
                        ->where('contadorTotal_ProduccionReal', '!=', 0)
                        ->where('numeroContenedor_NombreParteActual', '!=', '')
                        ->whereNotNull('numeroContenedor_NumeroParteActual')
                        ->groupBy('numeroContenedor_NumeroParteActual');

                    // Consulta principal que utiliza la subconsulta
                    $producnoche = DB::connection('ultateck')->table('dbo.Historial_TRF2500')
                        ->select(DB::raw('SUM(contadorTotal_ProduccionReal) as produc'))
                        ->whereIn('eventoTRF_Id', $subQueryN->pluck('maxev'))
                        ->first();
                    $val = array_search($currentMonday->format('d/m/Y'), array_column($planw, 'fecha'));
                    if ($val != false) {
                        $plane = $planw[$val];
                    } else {
                        // dd('no encontro')
                    }
                    // foreach ($planw as $pw) {
                    //     $recordDate = Carbon::createFromFormat('d/m/Y', $pw['fecha']);
                    //     if ($recordDate->format('d/m/Y')==$currentMonday->format('d/m/Y')) {
                    //         $plane=$pw['cantidad'];

                    //         break;
                    //     }
                    // }
                    $poducionok = 0;
            $poducionno = 0;
                    if(($producnoche->produc/5) < $plane['cantidad'])
                    {
                        $poducionno=$producnoche->produc;
                    }else{
                        $poducionok=$producnoche->produc;
                    }
                    $dataw = [
                        "golpes" => ($poducionok / 5) ?? 0,
                        "golpesno" =>($poducionno / 5) ?? 0,
                        "diames" => $currentMonday->format('m') . ' ' . $index . "W /<br>" . $producnoche->produc,
                        "plan" =>  $plane['cantidad'] ?? 0,
                        "plan1" =>  $plane['cantidad'] + 1500 ?? 0
                    ];
                    array_push($dias,   $dataw);
                } else {
                    $startOfMonth = $monday;
                }
            } else {
                $startOfMonth = $monday;
            }
        }


        $period = CarbonPeriod::create($startOfMonth, $endOfMonth);
        foreach ($period as $date) {
            $nextDay = $date->copy()->addDay();
            $fechaInicio = $date->format('d-m-Y') . ' 08:00:00';
            $fechaFin = $date->format('d-m-Y') . ' 20:06:00';
            // Subconsulta para obtener los máximos eventoTRF_Id por numeroContenedor_NumeroParteActual
            $subQuery = DB::connection('ultateck')->table('dbo.Historial_TRF2500')
                ->select('numeroContenedor_NumeroParteActual', DB::raw('MAX(eventoTRF_Id) as maxev'))
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->whereNotNull('contadorTotal_ProduccionReal')
                ->where('contadorTotal_ProduccionReal', '!=', 0)
                ->where('numeroContenedor_NombreParteActual', '!=', '')
                ->whereNotNull('numeroContenedor_NumeroParteActual')
                ->groupBy('numeroContenedor_NumeroParteActual');
            // Consulta principal que utiliza la subconsulta
            $produc = DB::connection('ultateck')->table('dbo.Historial_TRF2500')
                ->select(DB::raw('SUM(contadorTotal_ProduccionReal) as produc'))
                ->whereIn('eventoTRF_Id', $subQuery->pluck('maxev'))
                ->first();
            $fechaInicio = $date->format('d/m/Y') . ' 20:06:00';
            $fechaFin = $nextDay->format('d/m/Y') . ' 8:00:00';
            $subQueryN = DB::connection('ultateck')->table('dbo.Historial_TRF2500')
                ->select('numeroContenedor_NumeroParteActual', DB::raw('MAX(eventoTRF_Id) as maxev'))
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->whereNotNull('contadorTotal_ProduccionReal')
                ->where('contadorTotal_ProduccionReal', '!=', 0)
                ->where('numeroContenedor_NombreParteActual', '!=', '')
                ->whereNotNull('numeroContenedor_NumeroParteActual')
                ->groupBy('numeroContenedor_NumeroParteActual');

            // Consulta principal que utiliza la subconsulta
            $producnoche = DB::connection('ultateck')->table('dbo.Historial_TRF2500')
                ->select(DB::raw('SUM(contadorTotal_ProduccionReal) as produc'))
                ->whereIn('eventoTRF_Id', $subQueryN->pluck('maxev'))
                ->first();
            $buscarfe = $planmes->where('Fecha', $date->format('Y-m-d'))->where('Turno', 'D');
            $buscarfeN = $planmes->where('Fecha', $date->format('Y/m/d'))->where('Turno', 'N');
            $poducionok = 0;
            $poducionno = 0;
            if ($produc->produc < $buscarfe->first()->total_acumulado) {
                $poducionno = $produc->produc;
            } else {
                $poducionok =$produc->produc;
            }
            $datadia = [
                "golpes" =>  $poducionok,
                "golpesno" => $poducionno,
                "diames" => $date->format('d/m') . " D /n" . $produc->produc,
                "plan" => $buscarfe->first()->total_acumulado ?? 0,
                "plan1" => $buscarfe->first()->total_acumulado +1500?? 0
            ];
            array_push($dias,  $datadia);
            $poducionok = 0;
            $poducionno = 0;
            if ($producnoche->produc < $buscarfe->first()->total_acumulado) {
                $poducionno =$producnoche->produc;
            } else {
                $poducionok = $producnoche->produc;
            }
            $datano = [
                "golpes" => $poducionok,
                "golpesno" => $poducionno,
                "diames" => $date->format('d/m') . " N \n" . $producnoche->produc,
                "plan" => $buscarfe->first()->total_acumulado ?? 0,
                "plan1" => $buscarfe->first()->total_acumulado+1500?? 0
            ];
            array_push($dias,  $datano);
        }






        return view('IOT.charts', compact('dataall', 'turnoant',  'dias', 'contadorp'));
        // return view('IOT.charts');
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
