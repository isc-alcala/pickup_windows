<?php

namespace Database\Seeders;

use App\Models\Transicion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransicionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $transiciones= [
            ['estado_origen_id' => 2, 'estado_destino_id' => 3], // Notificación -> Arrivo
            ['estado_origen_id' => 3, 'estado_destino_id' => 4], // Arrivo -> Rampa
            ['estado_origen_id' => 4, 'estado_destino_id' => 5], // Rampa -> Liberación
            ['estado_origen_id' => 5, 'estado_destino_id' => 6], // Liberación -> Salida
            ['estado_origen_id' => 2, 'estado_destino_id' => 7], // Notificación -> Cancelada
            ['estado_origen_id' => 3, 'estado_destino_id' => 7], // Arrivo -> Cancelada
            ['estado_origen_id' => 4, 'estado_destino_id' => 7], // Rampa -> Cancelada
            ['estado_origen_id' => 5, 'estado_destino_id' => 7], // Liberación -> Cancelada
            ['estado_origen_id' => 6, 'estado_destino_id' => 7], // Salida -> Cancelada
       ];
       foreach ($transiciones as $transicion) {
        Transicion::create($transicion);
    }
    }
}
