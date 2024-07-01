<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'telefono', 'correo', 'cliente_id','estatus_id'];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function estatus()
    {
        return $this->belongsTo(estatus::class);
    }
}
