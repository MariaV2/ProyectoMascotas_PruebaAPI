<?php

namespace Database\Seeders;

use App\Models\Mascota;
use Illuminate\Database\Seeder;

class MascotaSeeder extends Seeder
{
    public function run()
    {
        Mascota::create([
            'nombre' => 'Luna',
            'especie' => 'perro',
            'edad' => 2,
            'descripcion' => 'Juguetona y amigable',
            'estado' => 'disponible'
        ]);

        Mascota::create([
            'nombre' => 'Miso',
            'especie' => 'gato',
            'edad' => 1,
            'descripcion' => 'Tranquilo y cariñoso',
            'estado' => 'disponible'
        ]);
    }
}