<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;
    protected $fillable = ['number_truck', 'number_container', 'trailer_plates', 'operator_name', 'back_operator_name', 'ETA', 'relaciones_id', 'estatus_id', 'user_id'];


    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function relaciones()
    {
        return $this->belongsTo(Relaciones::class);
    }
}
