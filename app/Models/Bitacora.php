<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $fillable = ['truck_id', 'user_id', 'estatus_id', 'comentario'];
    public function truck()
    {
        return $this->belongsTo(truck::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function estatus()
    {
        return $this->belongsTo(estatus::class);
    }
}
