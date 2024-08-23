<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estatus')->insert([
            'nombre' => 'Activo',
            'descripcion' => 'Activo'
        ]);
        DB::table('estatus')->insert([
            'nombre' => 'NOTIFICACION',
            'descripcion' => 'VENTANA CREADA'
        ]);
        DB::table('estatus')->insert([
            'nombre' => 'ARRIVO',
            'descripcion' => 'LLEGADA A CASETA'
        ]);
        DB::table('estatus')->insert([
            'nombre' => 'RAMPA',
            'descripcion' => 'ENRAMPADA EN EMBARQUE'
        ]);
        DB::table('estatus')->insert([
            'nombre' => 'LIBERACION',
            'descripcion' => 'LIBERADA POR EMBARQUE '
        ]);
        DB::table('estatus')->insert([
            'nombre' => 'SALIDA',
            'descripcion' => 'SALIDA  DE YKM '
        ]);
        DB::table('estatus')->insert([
            'nombre' => 'CANCELADA',
            'descripcion' => 'CANCELADA '
        ]);








    }
}
