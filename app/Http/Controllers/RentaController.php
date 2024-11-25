<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Ejemplar;
use App\Models\PrestamoEjemplar;
use App\Models\HistorialPrestamo;
use App\Models\Prestamo_ejemplar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RentaController extends Controller
{

    public function rentar(Request $request)
    {
        // Obtener el usuario actual
        $usuario = Auth::user();

        // Obtener los ejemplares seleccionados
        $ejemplaresSeleccionados = $request->input('ejemplares', []);

        // Obtener la cantidad de préstamos activos
        $prestamosActivosCount = $usuario->prestamosActivos()->count();  // Asegúrate de que la relación exista y se pueda contar

        // Determinar el máximo número de libros que se pueden seleccionar
        $maxSeleccion = 3 - $prestamosActivosCount; // Número máximo permitido basado en los préstamos activos
        if (count($ejemplaresSeleccionados) > $maxSeleccion) {
            return redirect()->back()->with('error', "Solo puedes rentar un máximo de $maxSeleccion libro(s) al mismo tiempo.");
        }

        // Procesar la renta de los ejemplares seleccionados
        foreach ($ejemplaresSeleccionados as $ejemplarId) {
            $ejemplar = Ejemplar::findOrFail($ejemplarId);

            // Verificar si el ejemplar está disponible
            if ($ejemplar->estado !== 'disponible') {
                return redirect()->back()->with('error', 'Uno de los libros seleccionados no está disponible.');
            }

            // Crear un nuevo préstamo
            $prestamo = new Prestamo([
                'usuario_id' => $usuario->id,
                'bibliotecario_id' => $usuario->id,
                'estado_prestamo' => 'pendiente',
                'fecha_prestamo' => now(),
                'fecha_devolucion_pactada' => now()->addDays(5), // Plazo de devolución de 5 días
            ]);
            $prestamo->save();

            // Asociar el ejemplar al préstamo
            $prestamo->ejemplares()->attach($ejemplar);

            // Cambiar el estado del ejemplar a 'prestado'
            $ejemplar->update(['estado' => 'en prestamo']);
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('catalogo')->with('success', 'Libro(s) rentado(s) exitosamente.');
    }

    public function mostrarPdf($id)
    {
        // Obtener el préstamo del usuario
        $prestamo = Prestamo::with('ejemplares')->findOrFail($id);

        // Verificar si el préstamo ha vencido
        if ($prestamo->fecha_devolucion_pactada < now()) {
            // Cambiar el estatus del usuario a "baja"
            $usuario = $prestamo->usuario;
            if ($usuario->status_usuario !== 'baja') {
                $usuario->update(['status_usuario' => 'baja']);
            }

            // Desloguear al usuario y redirigir al login
            Auth::logout();
            return redirect()->route('login.form')->with('error', 'Tu préstamo ha vencido y tu cuenta ha sido desactivada.');
        }

        // Obtener el ejemplar asociado al préstamo
        $ejemplar = $prestamo->ejemplares->first();

        // Obtener la ruta del PDF desde el campo 'ruta' de la tabla ejemplares
        $pdfPath =  $ejemplar->ruta;  // Ruta en la carpeta public/assets/pdf/

        // Comprobar si el archivo existe en la carpeta public/assets/pdf/
        if (!file_exists(public_path($pdfPath))) {
            return redirect('/')->with('error', 'El archivo PDF no está disponible.');
        }

        // Generar el enlace para ver el PDF
        return view('verPdf', compact('pdfPath', 'prestamo'));
    }


    public function devolverLibro($id)
    {
        try {
            // Encontrar el préstamo
            $prestamo = Prestamo::findOrFail($id);
            $prestamo->estado_prestamo = 'devuelto';
            $prestamo->save();

            // Cambiar el estado de los ejemplares a 'disponible' y agregar al historial
            foreach ($prestamo->ejemplares as $ejemplar) {
                // Actualizar el estado del ejemplar
                $ejemplar->update(['estado' => 'disponible']);

                // Agregar al historial de préstamos
                HistorialPrestamo::create([
                    'usuario_id' => $prestamo->usuario_id,
                    'ejemplar_id' => $ejemplar->id,
                    'fecha_inicio' => $prestamo->fecha_prestamo,
                    'fecha_devolucion' => now(),
                ]);
            }

            // Redirigir con mensaje de éxito
            return redirect()->route('catalogo')->with('success', 'El libro ha sido devuelto correctamente.');
        } catch (\Exception $e) {
            // Manejar errores
            return redirect()->back()->with('error', 'Error al devolver el libro: ' . $e->getMessage());
        }
    }
}
