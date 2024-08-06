<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



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
        $formattedDate1 = Carbon::now()->setTime(20, 6);
        $formattedDate2 = Carbon::now()->setTime(8, 0);

        $seleccionturno1 = Carbon::now();


        // dd($formattedDate,$seleccionturno );
        $matution = [];
        $nocturno = [];
        // $data = DB::connection('ultateck')->select('EXEC web_dashboard_actual_trf2500');
        //    dd($seleccionturno1->lte($formattedDate1) ,  !$formattedDate2->lte($seleccionturno1));
       
        if ($seleccionturno1->gte($formattedDate1)) {

            $formattedDate = Carbon::now()->setTime(20, 06)->format('Y-m-d H:i');
            $seleccionturno = Carbon::now()->format('Y-m-d H:i');
            // dd('noche1',$seleccionturno1->lte($formattedDate1),$seleccionturno1,$formattedDate1);
            $fechaInicio = Carbon::now()->setTime(8, 06);

            $fechaFin= Carbon::now()->addDay()->setTime(8, 0);
            //  dd($seleccionturno1->lte($formattedDate1),$seleccionturno1,$formattedDate1 );
        } else {
         
            if ($seleccionturno1->lte($formattedDate2)) {
                $formattedDate = Carbon::now()->subDay()->setTime(8, 06)->format('Y-m-d H:i');
                $seleccionturno = Carbon::now()->format('Y-m-d H:i');
                
                $fechaInicio = Carbon::now()->subDay()->setTime(8, 6);
                $fechaFin = Carbon::now()->setTime(8, 0);
            } else {
                $formattedDate = Carbon::now()->subDay()->setTime(8, 0)->format('Y-m-d H:i');
                $seleccionturno = Carbon::now()->format('Y-m-d H:i');
                $fechaInicio = Carbon::now()->subDay()->setTime(20, 6);
                $fechaFin = Carbon::now()->setTime(20, 6);
              
            }
        }
        
        
        $subQuery = DB::connection('ultateck')->table('Historial_TRF2500')
            ->select(
                DB::raw('MAX(eventoTRF_Id) as idm'),
                DB::raw("FORMAT(fecha, 'yyyy-MM-dd H') AS FechaHora"),
                'numeroContenedor_NombreParteActual'
            )
            ->where('fecha', '>=', $fechaInicio->format('d-m-Y H:m:s'))
            ->where('fecha', '<=', $fechaFin->format('d-m-Y H:m:s'))
            ->where('numeroContenedor_NombreParteActual', '!=', '')
            ->where('contadorTotal_ProduccionReal', '!=', 0)
            ->groupBy('numeroContenedor_NombreParteActual', DB::raw("FORMAT(fecha, 'yyyy-MM-dd H')"));
          
            $result = DB::connection('ultateck')->table('Historial_TRF2500 as h')
            ->joinSub($subQuery, 'subq2', function ($join) {
                $join->on('h.eventoTRF_Id', '=', 'subq2.idm');
            })
            ->select(
                'subq2.idm',
                'h.eventoTRF_Id',
                'h.contadorTotal_ProduccionReal',
                'subq2.FechaHora',
                'h.fecha',
                'h.numeroContenedor_NumeroParteActual',
                'h.numeroContenedor_NombreParteActual'
            )
            ->orderBy('subq2.FechaHora')
            ->get();
        
        
        $arrgr = [];
        $arrtotal = [];
        $hora = [];
        $part = 0;
        $cat = 0;
        $numero = 0;
        $partant = 0;
        $cantant = 0;
        $fec = 0;
        foreach ($result as $res) {
            $cat = $res->contadorTotal_ProduccionReal;
            $hora = $res->FechaHora;
            if (empty($arrtotal)) {
                $partant = $res->numeroContenedor_NombreParteActual;
                $cantant = $res->contadorTotal_ProduccionReal;
                $arrgr = ['hora' => $hora, 'cantidad' => $cat];
                array_push($arrtotal, $arrgr);
            } else {
                $part = $res->numeroContenedor_NombreParteActual;
                // dd($arrgr[count($arrgr)-1]);
                $ultimoElemento = end($arrtotal);
                $ultimokey = key($arrtotal);
                // dd( $ultimoElemento);

                if ($ultimoElemento['hora'] == $hora) {

                    $cat = $cat + $ultimoElemento['cantidad'];
                    $arrgr = ['hora' => $hora, 'cantidad' => $cat];
                    $arrtotal[$ultimokey] = $arrgr;


                } else {

                    if ($part == $partant) {

                        $cat = $cat - $cantant;
                        // dd( $cat,$cantant, $res->contadorTotal_ProduccionReal);
                    } else {

                        $cat = $cat + $ultimoElemento['cantidad'];
                        // dd($ultimoElemento['hora'], $hora,$arrgr,$arrtotal,$result,$part,$partant,$cat,$cantant);
                    }
                    // dd($hora, $part,$partant, $res->contadorTotal_ProduccionReal);

                    $arrgr = ['hora' => $hora, 'cantidad' => $cat];
                    array_push($arrtotal, $arrgr);

                }
                $partant = $res->numeroContenedor_NombreParteActual;
                $cantant = $res->contadorTotal_ProduccionReal;
            }
        }

// dd($fechaInicio->format('d-m-Y H:m:s'),$fechaFin->format('d-m-Y H:m:s'));
  

        // $data = DB::connection('ultateck')->select('EXEC web_dashboard_actual_trf2500');
        // $collection = collect($data);
        // $groupedResults = $collection->groupBy(function ($item) {
        //     return date('H', strtotime($item->fecha));
        // })->map(function ($hourlyData) {
        //     return [
        //         'total_piezas' => $hourlyData->sum('produccion'),
        //         'hora' => $hourlyData->max('fecha'),
        //     ];
        // });

        $planmes = DB::table('planprensas')->select(DB::raw('Fecha, Turno, SUM(cantidad) AS total_acumulado'))
            ->groupBy('Fecha', 'Turno')
            ->orderBy('Fecha')
            ->orderBy('Turno')
            ->get();



        $dataall = [];
        $turnoant = '';
        $turnoact = '';
        $hoy = Carbon::now()->format('d/m/Y');
        $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');

        // $fechaConHora = Carbon::createFromFormat('d/m/Y H:i:s','25/07/2024 21:00:00');
        $fechaConHoraplan = Carbon::createFromFormat('d/m/Y H:i:s', $hoy . ' 9:00:00');
        //  $fechaConHoraplan = Carbon::createFromFormat('d/m/Y H:i:s', '25/07/2024 21:00:00');

        $date1 = now();
        // $platurno = DB::table('planprensas')->select(DB::raw('Fecha, Turno, SUM(cantidad) AS total_acumulado'))
            // ->groupBy('Fecha', 'Turno')
            // ->where('Fecha', '=', $date1->format('d/m/Y'))
            // ->where('Turno', '=', 'D')
            // ->orderBy('Fecha')
            // ->orderBy('Turno')
            // ->get()->first();


        $PLANANT = 9000;
        // $PLANAct = $platurno->total_acumulado;
        // $PLANANT = 9000;
        // $PLANAct = 12000;
        $SUMD = 0;
        $SUMN = 0;
        $PLANHANT = $PLANANT / 10;
        $PLANHACT = $PLANANT / 10;
        $PLAN = 0;
        $dataall=[];
        // dd($dataall,$arrtotal,$fechaInicio,$fechaFin);
        while ($fechaInicio->lte($fechaFin)) {
            // Añadir la fecha actual al array
            array_push($dataall, $fechaInicio->format('d-m-Y H:i:s'));
            
            // Incrementar la fecha en 1 día
            $fechaInicio->addDay();
        }
        
        dd($dataall,$arrtotal,$fechaInicio,$fechaFin);
        // foreach ($groupedResults as $result) {
        //     if ($fechaConHoraplan->lte($result['hora'])) {
        //         $SUMN = 0;
        //         $SUMD += $PLANHANT;
        //         $PLAN = $SUMD;
        //     } else {
        //         $SUMD = 0;
        //         $SUMN += $PLANHACT;
        //         $PLAN = $SUMN;
        //     }
        //     $fechaOriginal = Carbon::parse($result['hora']);
        //     $fechaFormateada = $fechaOriginal->format('d/m H');
        //     if ($result['hora'])

        //         if ($fechaConHora->eq($result['hora'])) {

        //             $turnoant = $result['total_piezas'];
        //         } else {
        //             if ($result['total_piezas'] != 0) {
        //                 $turnoact = $result['total_piezas'];
        //             }
        //         }

        //     $rest = $result['total_piezas'] - floor($PLAN);
        //     if ($result['total_piezas'] < floor($PLAN)) {
        //         $rest = $rest * -1;
        //     } else {
        //         $rest = 0;
        //     }

        //     $data = [
        //         'hora' => $fechaFormateada . ' hras',
        //         'total_piezas' => $result['total_piezas'],
        //         'plan' => floor($PLAN),
        //         'plan1' => floor($PLAN) + 100,
        //         'dif' => $rest,
        //     ];
        //     array_push($dataall, $data);
        // }


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
                    if (($producnoche->produc / 5) < $plane['cantidad']) {
                        $poducionno = $producnoche->produc;
                    } else {
                        $poducionok = $producnoche->produc;
                    }
                    $dataw = [
                        "golpes" => ($poducionok / 5) ?? 0,
                        "golpesno" => ($poducionno / 5) ?? 0,
                        "diames" => $currentMonday->format('m') . ' ' . $index . "W " . $producnoche->produc,
                        "plan" => $plane['cantidad'] ?? 0,
                        "plan1" => $plane['cantidad'] + 1500 ?? 0
                    ];
                    array_push($dias, $dataw);
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
                $poducionok = $produc->produc;
            }
            $datadia = [
                "golpes" => $poducionok,
                "golpesno" => $poducionno,
                "diames" => $date->format('d/m') . " D /n" . $produc->produc,
                "plan" => $buscarfe->first()->total_acumulado ?? 0,
                "plan1" => $buscarfe->first()->total_acumulado + 1500 ?? 0
            ];
            array_push($dias, $datadia);
            $poducionok = 0;
            $poducionno = 0;
            if ($producnoche->produc < $buscarfe->first()->total_acumulado) {
                $poducionno = $producnoche->produc;
            } else {
                $poducionok = $producnoche->produc;
            }
            $datano = [
                "golpes" => $poducionok,
                "golpesno" => $poducionno,
                "diames" => $date->format('d/m') . " N \n" . $producnoche->produc,
                "plan" => $buscarfe->first()->total_acumulado ?? 0,
                "plan1" => $buscarfe->first()->total_acumulado + 1500 ?? 0
            ];
            array_push($dias, $datano);
        }






        return view('IOT.charts', compact('dataall', 'turnoant', 'dias'));
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
