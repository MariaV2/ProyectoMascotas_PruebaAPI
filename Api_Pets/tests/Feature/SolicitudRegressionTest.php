<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mascota;
use App\Models\Solicitud;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SolicitudRegressionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_usuario_autenticado_puede_crear_solicitud()
    {
        // Crear usuario y mascota
        $user = User::factory()->create();
        $mascota = Mascota::create([
            'nombre' => 'Luna',
            'especie' => 'perro',
            'edad' => 2,
            'descripcion' => 'Amigable y juguetona',
            'estado' => 'disponible'
        ]);

        // Autenticar al usuario con Sanctum
        $this->actingAs($user, 'sanctum');

        // Hacer la petición al endpoint protegido
        $response = $this->postJson("/api/mascotas/{$mascota->id}/solicitudes");

        // Verificaciones
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'solicitud' => ['id', 'user_id', 'mascota_id', 'estado']
                 ]);

        $this->assertDatabaseHas('solicitudes', [
            'user_id' => $user->id,
            'mascota_id' => $mascota->id,
            'estado' => 'pendiente'
        ]);
    }

    /** @test */
    public function un_usuario_no_autenticado_no_puede_crear_solicitud()
    {
        $mascota = Mascota::create([
            'nombre' => 'Miso',
            'especie' => 'gato',
            'edad' => 1,
            'descripcion' => 'Tranquilo y cariñoso',
            'estado' => 'disponible'
        ]);

        // No autenticado
        $response = $this->postJson("/api/mascotas/{$mascota->id}/solicitudes");

        $response->assertStatus(401);
    }

    /** @test */
    public function retorna_422_si_faltan_datos_requeridos()
    {
        // No se necesita datos porque el endpoint no requiere body,
        // así que simulamos un caso de mascota inexistente.
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Mascota con ID inexistente
        $response = $this->postJson("/api/mascotas/999/solicitudes");

        $response->assertStatus(404);
    }
}
