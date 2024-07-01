<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoRuta extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];
    public function ruta()
    {
        return $this->hasMany(Ruta::class);
    }
}

