<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'estatus_id'];
    public function relaciones()
    {
        return $this->hasMany(Relaciones::class);
    }
    public function estatus()
    {
        return $this->belongsTo(estatus::class);
    }
}
