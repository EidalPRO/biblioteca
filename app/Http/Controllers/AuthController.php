<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function crearUsuario()
    {
        return view('auth.crear');
    }

    public function register(Request $request)
    {
        try {
            // Validación del formulario
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido_paterno' => 'required|string|max:255',
                'apellido_materno' => 'required|string|max:255',
                'contrasena' => 'required|string|min:8',
                'numero_celular' => 'required|digits:10|unique:usuarios,numero_celular',
                'correo' => 'required|email|unique:usuarios,correo',
                'domicilio' => 'required|string|max:255',
                'tipo_usuario' => 'required|string|in:bibliotecario,estudiante,docente,externo',
                'numero_control' => 'nullable|required_if:tipo_usuario,estudiante|unique:usuarios,numero_control',
                'rfc' => 'nullable|required_if:tipo_usuario,bibliotecario,docente,externo|unique:usuarios,rfc',
                'ine' => 'nullable|required_if:tipo_usuario,bibliotecario,docente,externo|unique:usuarios,ine',
            ]);

            // No se puede repetir el correo ni el nmero en la base de datos
            if (Usuario::where('numero_celular', $request->numero_celular)->exists()) {
                return response()->json([
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'El número de celular ya está registrado.',
                ], 400);
            }

            if (Usuario::where('correo', $request->correo)->exists()) {
                return response()->json([
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'El correo electrónico ya está registrado.',
                ], 400);
            }

            // Crear usuario
            $usuario = Usuario::create([
                'contrasena' => Hash::make($request->contrasena),
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'numero_celular' => $request->numero_celular,
                'correo' => $request->correo,
                'tipo_usuario' => $request->tipo_usuario,
                'domicilio' => $request->domicilio,
                'numero_control' => $request->numero_control,
                'rfc' => $request->rfc,
                'ine' => $request->ine,
                'observaciones' => $request->observaciones,
                'status_usuario' => 'Activo',
            ]);

            // Autenticar usuario
            Auth::login($usuario);

            return response()->json([
                'icon' => 'success',
                'title' => 'Registro exitoso',
                'text' => 'Usuario creado y sesión iniciada.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error en el registro de usuario: ' . $e->getMessage());
            return response()->json([
                'icon' => 'error',
                'title' => 'Error inesperado',
                'text' => 'Ocurrió un error en el servidor, el correo, número, número de control, rfc y/o ine ya estan registrados.',
            ]);
        }
    }

    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Manejar el login
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'numero_celular' => 'nullable|digits:10',
            'correo' => 'nullable|email',
        ]);

        $user = null;
        if ($request->filled('numero_celular')) {
            $user = Usuario::where('numero_celular', $request->numero_celular)->first();
        } elseif ($request->filled('correo')) {
            $user = Usuario::where('correo', $request->correo)->first();
        }

        if (!$user) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Error de Autenticación',
                'text' => 'El número de celular o correo electrónico no existe.',
            ], 404);
        }

        if ($user->status_usuario === 'baja') {
            return response()->json([
                'icon' => 'error',
                'title' => 'Cuenta Desactivada',
                'text' => 'Tu cuenta ha sido desactivada debido a préstamos vencidos.',
            ], 403);
        }

        if (Auth::attempt($request->only('correo', 'password') ?: $request->only('numero_celular', 'password'))) {
            $request->session()->regenerate();
            return response()->json([
                'icon' => 'success',
                'title' => 'Inicio de Sesión Exitoso',
                'text' => '¡Bienvenido, ' . $user->nombre . '!',
            ]);
        }

        return response()->json([
            'icon' => 'error',
            'title' => 'Error de Autenticación',
            'text' => 'La contraseña es incorrecta.',
        ], 401);
    }



    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario
        $request->session()->invalidate(); // Invalida la sesión
        $request->session()->regenerateToken(); // Regenera el token CSRF para mayor seguridad

        return redirect('/'); // Redirige al inicio después de cerrar sesión
    }
}
