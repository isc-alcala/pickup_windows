<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TiporutaTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_de_ruta')->insert([
            'name' => 'T1',
            'descripcion' => 'Proveedor directo'
        ]);
        DB::table('tipo_de_ruta')->insert([
            'name' => 'T2',
            'descripcion' => 'Proveedor Indirecto'
        ]);
    }
}
