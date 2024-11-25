<?php

namespace App\Http\Controllers;

use App\Models\Ejemplar;
use App\Models\HistorialPrestamo;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;

class CatalogoController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->status_usuario === 'baja') {
            Auth::logout();
            return redirect()->route('login.form')->with('error', 'Tu cuenta ha sido desactivada debido a préstamos vencidos.');
        }


        // Obtener todos los libros con sus relaciones sin ordenación
        $libros = Libro::with(['editorial', 'autores', 'ejemplares'])->get();

        // Obtener los libros recomendados con los IDs específicos (12, 10, 7)
        $librosRecomendados = Libro::with(['editorial', 'autores'])
            ->whereIn('id', [9, 12, 16])
            ->get();

        // Manejar el caso de usuario no autenticado
        $usuario = Auth::user();

        // Obtener los préstamos activos y el historial solo si hay un usuario autenticado
        $prestamosActivos = $usuario ? Prestamo::where('usuario_id', $usuario->id)
            ->whereIn('estado_prestamo', ['pendiente', 'en préstamo'])
            ->with('ejemplares')
            ->get() : collect();

        $historialPrestamos = $usuario ? HistorialPrestamo::where('usuario_id', $usuario->id)
            ->with('ejemplar.libro')
            ->get() : collect();

        // Verificar los préstamos actuales del usuario
        $prestamosActivosCount = $usuario ? $prestamosActivos->count() : 0;

        // Determinar cuántas casillas se pueden marcar
        $maxSeleccion = $usuario ? 3 - $prestamosActivosCount : 3;

        // Obtener los ejemplares disponibles
        $ejemplaresDisponibles = Ejemplar::where('estado', 'disponible')->get();

        // Pasar los datos a la vista
        return view('welcome', compact(
            'libros',
            'librosRecomendados',
            'ejemplaresDisponibles',
            'maxSeleccion',
            'prestamosActivos',
            'historialPrestamos'
        ));
    }
}
