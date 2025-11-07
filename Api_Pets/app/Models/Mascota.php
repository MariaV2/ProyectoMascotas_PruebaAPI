<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascotas';
    protected $fillable = ['nombre','especie','edad','descripcion','estado'];

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'mascota_id');
    }
}