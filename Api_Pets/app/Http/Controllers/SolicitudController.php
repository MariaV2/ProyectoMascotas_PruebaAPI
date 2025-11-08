<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Solicitud;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/mascotas/{id}/solicitudes",
 *     summary="Crear una solicitud de adopciÃ³n",
 *     security={{"sanctum":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la mascota",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=201, description="Solicitud creada correctamente")
 * )
 *
 * @OA\Get(
 *     path="/api/solicitudes",
 *     summary="Listar solicitudes del usuario (o todas si es admin)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(response=200, description="Lista de solicitudes")
 * )
 */

class SolicitudController extends Controller
{
    public function store(Request $r, $id)
    {
        $mascota = Mascota::findOrFail($id);

        // Crea la solicitud con el usuario autenticado
        $sol = Solicitud::create([
            'user_id' => $r->user()->id,
            'mascota_id' => $mascota->id,
            'estado' => 'pendiente'
        ]);

        return response()->json([
            'message' => 'Solicitud enviada correctamente',
            'solicitud' => $sol
        ], 201);
    }

    public function index(Request $r)
    {
        $user = $r->user();

        // Si es admin, devuelve todas; si no, solo las del usuario
        if ($user->rol === 'admin') {
            $list = Solicitud::with(['mascota', 'user'])->get(); 
        } else {
            $list = Solicitud::with('mascota')->where('user_id', $user->id)->get(); 
        }

        return response()->json($list, 200);
    }
}
