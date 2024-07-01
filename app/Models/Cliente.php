<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'proyectos', 'type_supplier_id'];

    public function relaciones()
    {
        return $this->hasMany(Relaciones::class);
    }
    public function contactos()
    {
        return $this->hasMany(contactos::class);
    }
    public function typesupplier()
    {
        return $this->belongsTo(typesupplier::class);
    }

}
