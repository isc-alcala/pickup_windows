<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transicion extends Model
{
    protected $table = 'transiciones';

    protected $fillable = [
        'estado_origen_id',
        'estado_destino_id'
    ];

    // Relación con el modelo Estatus para el estado de origen
    public function estadoOrigen()
    {
        return $this->belongsTo(Estatus::class, 'estado_origen_id');
    }

    // Relación con el modelo Estatus para el estado de destino
    public function estadoDestino()
    {
        return $this->belongsTo(Estatus::class, 'estado_destino_id');
    }
}
