<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relaciones extends Model
{
    use HasFactory;

    protected $table = 'relaciones';

    public function rutas()
    {
        return $this->belongsTo(Rutas::class,'ruta_id');
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function contactoDirecto()
    {
        return $this->belongsTo(contactoDirecto::class);
    }
    public function truck()
    {
        return $this->hasMany(truck::class);
    }
}
