@extends('layouts.app')

@section('titulo', 'BiblioPlus - Inicio de sesión')

@section('nav')
<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="/">Inicio<br></a></li>
        <!-- <li><a href="#speakers">Speakers</a></li> -->
        <li><a href="{{route('login.form')}}" class="active">Iniciar sesión</a></li>
        <li><a href=" {{route('usuarios.create')}} ">Registrarse</a></li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
@endsection

@section('title-page', 'Iniciar sesión')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container">
    <h2>Iniciar Sesión</h2>

    <!-- Botones para elegir el método de login -->
    <div class="d-flex justify-content-center mb-3">
        <button id="btn-telefono" class="btn btn-primary mx-2">Por Número de Teléfono</button>
        <button id="btn-correo" class="btn btn-secondary mx-2">Por Correo Electrónico</button>
    </div>

    <!-- Formulario de login por número de teléfono -->
    <form id="form-telefono" action="{{ route('login') }}" method="POST" style="display: block;">
        @csrf
        <div class="mb-3">
            <label for="numero_celular" class="form-label">Número de Teléfono</label>
            <input type="text" name="numero_celular" id="numero_celular" class="form-control" placeholder="Ingrese su número de teléfono" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contraseña" required>
        </div>

        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>

    <!-- Formulario de login por correo -->
    <form id="form-correo" action="{{ route('login') }}" method="POST" style="display: none;">
        @csrf
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo electrónico" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contraseña" required>
        </div>

        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
</div>

<script>
    // Mostrar y ocultar formularios según la opción seleccionada
    document.getElementById('btn-telefono').addEventListener('click', function() {
        document.getElementById('form-telefono').style.display = 'block';
        document.getElementById('form-correo').style.display = 'none';
    });

    document.getElementById('btn-correo').addEventListener('click', function() {
        document.getElementById('form-telefono').style.display = 'none';
        document.getElementById('form-correo').style.display = 'block';
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            console.log('Formulario enviado', formData); // Agrega un log para verificar el formulario

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                const data = await response.json();
                console.log('Respuesta del servidor', data); // Verifica la respuesta del servidor

                if (!response.ok) {
                    Swal.fire({
                        icon: data.icon || 'error',
                        title: data.title || 'Error',
                        text: data.text || 'Ocurrió un error desconocido.',
                    });
                    return;
                }

                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,
                }).then(() => {
                    if (data.icon === 'success') {
                        window.location.href = '/'; // Redirige al inicio o donde prefieras
                    }
                });

            } catch (error) {
                console.error('Error en el frontend:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error inesperado',
                    text: 'No se pudo procesar tu solicitud. Por favor, intenta nuevamente.',
                });
            }
        });
    });
</script>
@endsection