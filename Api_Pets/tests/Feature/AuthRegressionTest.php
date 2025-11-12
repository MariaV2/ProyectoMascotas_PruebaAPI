<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegressionTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    /**
     * Prueba de regresión: login exitoso con credenciales válidas.
     * Verifica que el endpoint siga devolviendo el token correctamente.
     */
    #[Test]
    public function test_login_exitoso_con_credenciales_validas()
    {
        // Creamos un usuario de prueba con credenciales conocidas
        $user = User::factory()->create([
            'email' => 'usuario@example.com',
            'password' => bcrypt('Password123!')
        ]);

        // Intentamos iniciar sesión
        $response = $this->postJson('/api/login', [
            'email' => 'usuario@example.com',
            'password' => 'Password123!'
        ]);

        // Comprobamos que el login funcione correctamente
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token',
            'user' => ['id', 'name', 'email']
        ]);
    }

    /**
     * Prueba de regresión: login con contraseña incorrecta.
     * Verifica que se mantenga la validación de credenciales inválidas.
     */
    #[Test]
    public function test_login_falla_con_contrasena_incorrecta()
    {
        $user = User::factory()->create([
            'email' => 'usuario@example.com',
            'password' => bcrypt('Password123!')
        ]);

        // Probamos con una contraseña errónea
        $response = $this->postJson('/api/login', [
            'email' => 'usuario@example.com',
            'password' => 'Password1234!' // <- ligeramente diferente
        ]);

        // Debe retornar 401 Unauthorized
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Credenciales inválidas'
        ]);
    }

    /**
     * Prueba de regresión: login con caracteres especiales y espacios.
     * Asegura que la API maneje correctamente los formatos extraños
     * sin romper validaciones ni lanzar errores del servidor.
     */
   #[Test]
public function login_con_caracteres_invalidos_o_formato_inusual(): void
{
    $response = $this->postJson('/api/login', [
        'email' => '   usuario@@@.com  ',
        'password' => '  pass   '
    ]);

    $response->assertStatus(422);
    // Solo verificamos el campo que efectivamente tiene errores
    $response->assertJsonValidationErrors(['email']);
}

}
