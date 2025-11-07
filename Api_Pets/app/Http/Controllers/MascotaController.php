<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

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