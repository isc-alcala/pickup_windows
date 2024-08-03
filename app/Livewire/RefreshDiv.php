<?php

namespace App\Livewire;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RefreshDiv extends Component
{
    public $time;
    public $produc;
    public $plandiag;
    public $turnoactg;
    public $totaldia;
    public $item;
    public $canpart;
    public $contpieza;
    public function mount()
    {
        $this->updateTime();
    }

    public function updateTime()
    {

        $date = now();
        $sqldia = "
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
                WHERE (fecha > '" . $date->format('d/m/Y') . " 08:00:00' AND fecha < '" .  $date->format('d/m/Y') . " 20:06:00')
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

        $resultdia = DB::connection('ultateck')->select($sqldia);
        $golpesdia = $resultdia[0];
        $turnoact = $golpesdia->produc;



        $planmes = DB::table('planprensas')->select(DB::raw('Fecha, Turno, SUM(cantidad) AS total_acumulado'))
            ->groupBy('Fecha', 'Turno')
            ->where('Fecha', '=', $date->format('d/m/Y'))
            ->where('Turno', '=', 'D')
            ->orderBy('Fecha')
            ->orderBy('Turno')
            ->get();

        $plandia = $planmes->where('Fecha', now()->format('Y-m-d'))->sum('total_acumulado');
        $total = $turnoact - $plandia;


        $contadorp = DB::connection('ultateck')->table('Historial_TRF2500')->orderby('fecha', 'desc')->first();
        $cleanedData = str_replace("-", '', str_replace("\x00", '', $contadorp->numeroContenedor_NombreParteActual));

        $itemsqury = DB::table('planprensas')
            ->select(
                'Fecha',
                'Turno',
                'cantidad',
                DB::raw("REPLACE(REPLACE(NUMERO_DE_PARTE, ' ', ''), '-', '') as cleaned_numero_de_parte")
            )
            ->where('Fecha', '=', $date->format('d/m/Y'))
            ->where('Turno', '=', 'D')
            ->where('NUMERO_DE_PARTE', '=', $cleanedData)
            ->orderBy('Fecha')
            ->orderBy('Turno')
            ->get()->first();
            $hora8AM = Carbon::today()->setTime(8, 0);

            // Obtener la hora actual
            $ahora = Carbon::now();

            // Calcular la diferencia en horas
            $horasTranscurridas = $ahora->diffInHours($hora8AM);


            $evance=($plandia/10)*$horasTranscurridas;

        if ($contadorp) {
            $this->time = $date->format('d/m/Y');
            $this->produc = $contadorp->contadorTotal_ProduccionReal;
            $this->plandiag = $plandia;
            $this->turnoactg = $turnoact;
            $this->item= $cleanedData;
            $this->totaldia = $total;
            $this->canpart= $evance??0;

        } else {
            $this->time = 'No data found';
        }
    }

    public function render()
    {
        return view('livewire.refresh-div');
    }
}
