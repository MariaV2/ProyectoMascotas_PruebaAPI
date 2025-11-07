<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'user_id',
        'mascota_id',
        'estado'
    ];

    // Relación: una solicitud pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación: una solicitud pertenece a una mascota
    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }
}