<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/mascotas",
 *     summary="Obtener todas las mascotas disponibles",
 *     @OA\Response(response=200, description="Listado de mascotas")
 * )
 *
 * @OA\Get(
 *     path="/api/mascotas/{id}",
 *     summary="Obtener detalles de una mascota",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Detalles de la mascota")
 * )
 */

class MascotaController extends Controller
{
    public function index(Request $r)
    {
        $query = Mascota::query();
        if ($r->has('especie')) $query->where('especie', $r->query('especie'));
        return response()->json($query->get(), 200);
    }

    public function show($id)
    {
        $pet = Mascota::findOrFail($id);
        return response()->json($pet, 200);
    }

    
}