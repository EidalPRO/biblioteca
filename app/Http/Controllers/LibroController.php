<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Autor;
use App\Models\Editorial;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Obtener todos los libros.
     */
    public function index()
    {
        // Obtener todos los libros con sus relaciones de autores y editoriales
        $libros = Libro::with(['editorial', 'autores'])->get();
        return response()->json($libros);
    }

    /**
     * Agregar un nuevo libro.
     */
    public function store(Request $request)
    {
        // Validación de los datos del libro
        $request->validate([
            'titulo' => 'required|string|max:255',
            'editorial_id' => 'required|integer|exists:editoriales,id',
            'autor_id' => 'required|integer|exists:autores,id', // Asumiendo que autor_id es requerido
            'codigo' => 'required|string|max:255', // El código debe ser único, pero puedes ajustar esta validación si es necesario
        ]);

        try {
            // Crear el libro con los datos recibidos
            $libro = Libro::create([
                'titulo' => $request->titulo,
                'editorial_id' => $request->editorial_id,
                'autor_id' => $request->autor_id,  // Aquí está el autor
                'codigo' => $request->codigo,
            ]);

            return response()->json(['success' => true, 'libro' => $libro]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear el libro'], 500);
        }
    }

    /**
     * Actualizar un libro existente.
     */
    public function update(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'id' => 'required|exists:libros,id', // Verificar que el libro existe
            'titulo' => 'required|string|max:255',
            'editorial_id' => 'required|integer|exists:editoriales,id',
            'autor_id' => 'required|integer|exists:autores,id',
            'codigo' => 'required|string|max:255',
        ]);

        try {
            // Buscar el libro por ID
            $libro = Libro::findOrFail($request->id);

            // Actualizar los datos del libro
            $libro->update([
                'titulo' => $request->titulo,
                'editorial_id' => $request->editorial_id,
                'autor_id' => $request->autor_id,
                'codigo' => $request->codigo,
            ]);

            return response()->json(['success' => true, 'libro' => $libro]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el libro'], 500);
        }
    }

    /**
     * Eliminar un libro.
     */
    public function destroy(Request $request)
    {
        // Validar que el ID sea correcto
        $request->validate([
            'id' => 'required|exists:libros,id',
        ]);

        try {
            // Buscar el libro por ID
            $libro = Libro::findOrFail($request->id);
            $libro->delete(); // Eliminar el libro

            return response()->json(['success' => true, 'message' => 'Libro eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el libro'], 500);
        }
    }
}
