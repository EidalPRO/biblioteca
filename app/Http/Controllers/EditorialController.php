<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
{
    public function index()
    {
        $editoriales = Editorial::all();
        return response()->json($editoriales);
    }

    public function show($id)
    {
        $editorial = Editorial::find($id);

        // Verificar si la editorial existe
        if (!$editorial) {
            return response()->json(['message' => 'Editorial no encontrada'], 404);
        }

        return response()->json($editorial);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|digits:10',
            'correo' => 'nullable|email',
        ]);

        try {
            Editorial::create($request->all());
            return response()->json(['success' => true, 'message' => 'Editorial creada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear la editorial.']);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:editoriales,id',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|digits:10',
            'correo' => 'nullable|email',
        ]);

        try {
            $editorial = Editorial::findOrFail($request->id);
            $editorial->update($request->all());
            return response()->json(['success' => true, 'message' => 'Editorial actualizada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar la editorial.']);
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:editoriales,id',
        ]);

        try {
            $editorial = Editorial::findOrFail($request->id);
            $editorial->delete();
            return response()->json(['success' => true, 'message' => 'Editorial eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar la editorial.']);
        }
    }
}
