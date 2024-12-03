<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class InformeController extends Controller
{
    public function generarReporte()
    {
        try {
            // Obtener datos necesarios
            $libros = Libro::with(['autores', 'editorial', 'ejemplares.prestamos.usuario'])->get();
            $usuariosBaja = Usuario::where('status_usuario', 'baja')->with(['prestamos.ejemplares.libro'])->get();

            // Verificar si hay datos disponibles
            if ($libros->isEmpty() && $usuariosBaja->isEmpty()) {
                return response()->json(['error' => 'No hay datos para generar el reporte.'], 404);
            }

            // Generar contenido del PDF
            $html = '<h1>Reporte de Inventario</h1>';

            // Agregar información de libros
            $html .= '<h2>Libros</h2>';
            $html .= '<table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Editorial</th>
                    <th>Autores</th>
                    <th>Ejemplares Prestados</th>
                    <th>Usuarios a los que se prestaron</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($libros as $libro) {
                $autores = $libro->autores->pluck('nombre')->join(', ');
                $editorial = $libro->editorial->nombre ?? 'N/A';
                $usuarios = $libro->ejemplares->flatMap(fn($ejemplar) => $ejemplar->prestamos->pluck('usuario.nombre'))->unique()->join(', ');

                $html .= "<tr>
                <td>{$libro->titulo}</td>
                <td>{$editorial}</td>
                <td>{$autores}</td>
                <td>{$libro->ejemplares->count()}</td>
                <td>{$usuarios}</td>
            </tr>";
            }
            $html .= '</tbody></table>';

            // Agregar información de usuarios dados de baja
            $html .= '<h2>Usuarios dados de baja</h2>';
            $html .= '<table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Libro No Regresado</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($usuariosBaja as $usuario) {
                $librosNoRegresados = $usuario->prestamos->flatMap(fn($prestamo) => $prestamo->ejemplares->pluck('libro.titulo'))->unique()->join(', ');
                $html .= "<tr>
                <td>{$usuario->nombre}</td>
                <td>{$usuario->numero_celular}</td>
                <td>{$librosNoRegresados}</td>
            </tr>";
            }
            $html .= '</tbody></table>';

            // Generar PDF con el contenido
            $pdf = PDF::loadHTML($html);

            // Guardar el PDF en la carpeta pública
            $fileName = 'reporte_inventario_' . now()->format('Y_m_d_His') . '.pdf';
            $filePath = public_path('assets/pdf/inventario/' . $fileName);

            $pdf->save($filePath);

            // Descargar el PDF
            return response()->download($filePath)->deleteFileAfterSend();
        } catch (\Exception $e) {
            Log::error('Error generando reporte: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar el reporte.'], 500);
        }
    }
}
