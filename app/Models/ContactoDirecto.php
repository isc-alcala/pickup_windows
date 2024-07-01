<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoDirecto extends Model
{
    use HasFactory;

    protected $table = 'contacto_directo';

    protected $fillable = ['nombre', 'descripcion','estatus_id'];

    public function relaciones()
    {
        return $this->hasMany(Relaciones::class);
    }
    public function Contactocontactodirecto()
    {
        return $this->hasMany(Contactos_contacto_directo::class);
    }
    public function estatus()
    {
        return $this->belongsTo(estatus::class);
    }
}
