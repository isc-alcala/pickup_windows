<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estatus extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion'];
    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }
    public function contactos()
    {
        return $this->hasMany(contactos::class);
    }
    public function carrier()
    {
        return $this->hasMany(carrier::class);
    }
    public function ruta()
    {
        return $this->hasMany(ruta::class);
    }
    public function contactodirecto()
    {
        return $this->hasMany(contactodirecto::class);
    }
    public function contactoscontactodirecto()
    {
        return $this->hasMany(contactos_contacto_directo::class);
    }
}

