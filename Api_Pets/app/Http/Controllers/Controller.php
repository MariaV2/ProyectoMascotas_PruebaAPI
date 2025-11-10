<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="API de Adopción de Mascotas",
 *     version="1.0.0",
 *     description="API desarrollada para gestionar la adopción de mascotas. Incluye registro, autenticación, visualización de mascotas disponibles y envío de solicitudes de adopción.",
 *     @OA\Contact(
 *         name="Equipo Stardust",
 *         email="soporte@apipets.com"
 *     ),
 *     @OA\License(
 *         name="ApiPets",
 *         url="https://opensource.org/licenses/ApiPets"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local de desarrollo"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Ingrese el token en el formato: Bearer {token}"
 * )
 * 
 * @OA\Tag(
 *      name="Mascotas",
 *      description="Proyecto de desarrollo de Api para mantenimiento de tabla de BD de adopcion de mascotas especificamente para la tabla mascotas"
 * )
 */

abstract class Controller
{
    //
}
