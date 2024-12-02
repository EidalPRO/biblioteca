<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        return response()->json(Autor::all());
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        try {
            // Crear el autor
            $autor = Autor::create([
                'nombre' => $request->nombre,
            ]);

            // Devolver la respuesta
            return response()->json(['success' => true, 'autor' => $autor]);
        } catch (\Exception $e) {
            // Manejar error si ocurre
            return response()->json(['error' => false, 'message' => 'Error al crear el autor: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        $autor = Autor::findOrFail($request->id);
        $autor->update([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
        ]);

        return response()->json(['success' => true, 'autor' => $autor]);
    }

    public function destroy(Request $request)
    {
        $autor = Autor::findOrFail($request->id);
        $autor->delete();

        return response()->json(['success' => true]);
    }
}
