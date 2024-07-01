<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactos_contacto_directo extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'telefono', 'correo', 'contacto_directo_id','estatus_id'];

    public function contactoDirecto()
    {
        return $this->belongsTo(ContactoDirecto::class);
    }
    public function estatus()
    {
        return $this->belongsTo(estatus::class);
    }
}
