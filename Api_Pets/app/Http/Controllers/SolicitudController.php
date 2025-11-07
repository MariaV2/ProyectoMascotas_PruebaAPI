<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function store(Request $r, $id)
    {
        $r->validate(['message' => 'nullable|string']); // opcional: guardar message más tarde
        $mascota = Mascota::findOrFail($id);

        // Crea la solicitud usando el usuario autenticado
        $sol = Solicitud::create([
            'usuario_id' => $r->user()->id,
            'mascota_id' => $mascota->id,
            'estado' => 'pendiente'
        ]);

        return response()->json($sol, 201);
    }

    public function index(Request $r)
    {
        $user = $r->user();

        // Si es admin (rol), devuelve todas; si no, solo las del usuario
        if ($user->rol === 'admin') {
            $list = Solicitud::with(['mascota','usuario'])->get();
        } else {
            $list = Solicitud::with('mascota')->where('usuario_id', $user->id)->get();
        }

        return response()->json($list, 200);
    }
}