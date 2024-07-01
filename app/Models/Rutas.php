<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    use HasFactory;

    protected $table = 'rutas';

    public function relaciones()
    {
        return $this->hasMany(Relaciones::class,'id');
    }
    public function estatus()
    {
        return $this->belongsTo(estatus::class);
    }
    public function tiporuta()
    {
        return $this->belongsTo(tiporuta::class);
    }
}
