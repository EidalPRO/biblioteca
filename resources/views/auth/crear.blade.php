@extends('layouts.app')

@section('titulo', 'BiblioPlus - Registro')

@section('nav')
<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="/">Inicio<br></a></li>
        <!-- <li><a href="#speakers">Speakers</a></li> -->
        <li><a href="{{route('login.form')}}">Iniciar sesión</a></li>
        <li><a href=" {{route('usuarios.create')}} " class="active">Registrarse</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
@endsection

@section('title-page', 'Registro de usuario')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container">
    <h2>Registrar Nuevo Usuario</h2>
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="apellido_materno" class="form-label">Apellido Materno</label>
            <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="numero_celular" class="form-label">Número Celular</label>
            <input type="text" name="numero_celular" id="numero_celular" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio</label>
            <input type="text" name="domicilio" id="domicilio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-select" required>
                <option value=""></option>
                <option value="bibliotecario">Bibliotecario</option>
                <option value="estudiante">Estudiante</option>
                <option value="docente">Docente</option>
                <option value="externo">Externo</option>
            </select>
        </div>

        <div class="mb-3" id="campo-estudiante" style="display: none;">
            <label for="numero_control" class="form-label">Número de Control</label>
            <input type="text" name="numero_control" id="numero_control" class="form-control">
        </div>

        <div class="mb-3" id="campo-otros" style="display: none;">
            <label for="rfc" class="form-label">RFC</label>
            <input type="text" name="rfc" id="rfc" class="form-control">

            <label for="ine" class="form-label">INE</label>
            <input type="text" name="ine" id="ine" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

<script>
    document.getElementById('tipo_usuario').addEventListener('change', function() {
        const estudiante = document.getElementById('campo-estudiante');
        const otros = document.getElementById('campo-otros');

        if (this.value === 'estudiante') {
            estudiante.style.display = 'block';
            otros.style.display = 'none';
        } else {
            estudiante.style.display = 'none';
            otros.style.display = 'block';
        }
    });
    document.querySelector('form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = new FormData(this);

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: form,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Error en el servidor:', errorText);
                throw new Error('Error en el servidor');
            }

            const data = await response.json();

            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
            }).then(() => {
                if (data.icon === 'success') {
                    window.location.href = '/'; // Redirige después del éxito
                }
            });
        } catch (error) {
            console.error('Error en el frontend:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error inesperado',
                text: 'Ocurrió un error al registrar al usuario.',
            });
        }
    });
</script>
@endsection