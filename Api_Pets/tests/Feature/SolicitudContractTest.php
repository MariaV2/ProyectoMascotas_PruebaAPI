<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mascota;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SolicitudContractTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_respuesta_de_crear_solicitud_cumple_con_el_contrato()
    {
        // Crear datos
        $user = User::factory()->create();
        $mascota = Mascota::create([
            'nombre' => 'Rocky',
            'especie' => 'perro',
            'edad' => 3,
            'descripcion' => 'Energético y protector',
            'estado' => 'disponible'
        ]);

        // Autenticar
        $this->actingAs($user, 'sanctum');

        // Hacer la solicitud
        $response = $this->postJson("/api/mascotas/{$mascota->id}/solicitudes");

        // Validar contrato (estructura y tipos)
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Solicitud enviada correctamente',
                 ])
                 ->assertJsonStructure([
                     'message',
                     'solicitud' => [
                         'id',
                         'user_id',
                         'mascota_id',
                         'estado',
                         'created_at',
                         'updated_at'
                     ]
                 ]);

        // Validar tipos básicos
        $data = $response->json('solicitud');
        $this->assertIsInt($data['id']);
        $this->assertIsInt($data['user_id']);
        $this->assertIsInt($data['mascota_id']);
        $this->assertIsString($data['estado']);
    }
}
