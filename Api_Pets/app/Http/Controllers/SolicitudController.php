<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Solicitud;
use Illuminate\Http\Request;

 /**
     * @OA\Post(
     *     path="/api/mascotas/{id}/solicitudes",
     *     summary="Crear una solicitud de adopción",
     *     description="Crea una nueva solicitud de adopción para la mascota especificada.",
     *     security={{"BearerAuth":{}}},
     *     tags={"Solicitudes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota a adoptar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Solicitud creada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Solicitud enviada correctamente"),
     *             @OA\Property(property="solicitud", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="mascota_id", type="integer", example=1),
     *                 @OA\Property(property="estado", type="string", example="pendiente")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Mascota no encontrada")
     * )
     *
     * @OA\Get(
     *     path="/api/solicitudes",
     *     summary="Listar solicitudes del usuario (o todas si es admin)",
     *     description="Devuelve las solicitudes del usuario autenticado o todas si el usuario es administrador.",
     *     security={{"BearerAuth":{}}},
     *     tags={"Solicitudes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de solicitudes obtenida correctamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="mascota_id", type="integer", example=1),
     *                 @OA\Property(property="estado", type="string", example="pendiente")
     *             )
     *         )
     *     )
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
