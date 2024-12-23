<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Biblioteca</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: TheEvent
  * Template URL: https://bootstrapmade.com/theevent-conference-event-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <!-- Uncomment the line below if you also wish to use an text logo -->
                <h1 class="sitename">BiblioPlus</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/" class="active">Inicio<br></a></li>
                    <li><a href="#catalogo">Catálogo</a></li>
                    <li><a href="#cbtis">CBTis</a></li>
                    <li><a href="#recomendado">Recomendado</a></li>

                    @auth
                    <!-- Mostrar cuando el usuario tiene la sesión iniciada -->
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">{{ Auth::user()->nombre }} - Mi perfil</a> <!-- Muestra el nombre del usuario -->
                    </li>

                    <!-- Verificar roles específicos -->
                    @if (in_array(Auth::user()->tipo_usuario, ['bibliotecario', 'administrativo', 'directivo']))
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#adminLibrosModal">Administrar Libros</a>
                    </li>
                    @endif

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link" style="text-decoration: none; padding: 0; background: none;">
                                Cerrar sesión
                            </button>
                        </form>
                    </li>
                    @else
                    <!-- Mostrar cuando el usuario no está autenticado -->
                    <li><a href="{{ route('login.form') }}">Iniciar sesión</a></li>
                    <li><a href="{{ route('usuarios.create') }}">Registrarse</a></li>
                    @endauth
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>


            <a class="cta-btn d-none d-sm-block"
                @auth
                data-bs-toggle="modal"
                data-bs-target="#staticBackdrop"
                @else
                href="{{ route('login.form') }}"
                @endauth>
                Rentar un libro
            </a>


        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in" class="">

            <div class="container d-flex flex-column align-items-center text-center mt-auto">
                <h2 data-aos="fade-up" data-aos-delay="100" class="">Bienvenidos a la<br><span>Biblioteca Escolar </span>Plus</h2>
                <!-- <p data-aos="fade-up" data-aos-delay="200">10-12 December, Downtown Conference Center, New York</p> -->
                <!-- <div data-aos="fade-up" data-aos-delay="300" class="">
                    <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn mt-3"></a>
                </div> -->
            </div>

            <div class="about-info mt-auto position-relative">

                <div class="container position-relative" data-aos="fade-up">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- <h2>Acerca de</h2> -->
                            <p>Un sistema de gestión eficiente para bibliotecas escolares, que permite a bibliotecarios y estudiantes gestionar el inventario, realizar préstamos y devoluciones, y acceder a reportes detallados de forma rápida y sencilla.</p>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- Schedule Section -->
        <section id="catalogo" class="schedule section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Catálogo de Libros</h2>
                <p>Consulta el catálogo completo de libros disponibles.</p>
            </div>

            <div class="container d-flex justify-center align-center">
                <div class="container">
                    @foreach ($libros as $libro)

                    <div class="row schedule-item">
                        <div class="col-md-2">
                            <time>
                                @if ($libro->ejemplares->where('estado', 'disponible')->count() > 0)
                                Disponible
                                @else
                                No disponible
                                @endif
                            </time>
                        </div>
                        <div class="col-md-10">
                            <!-- Mostrar la imagen de la portada -->
                            <div class="speaker">
                                @if ($libro->imagen_portada)
                                <img src="{{ asset($libro->imagen_portada) }}" alt="Portada de {{ $libro->titulo }}">
                                @else
                                <img src="{{ asset('img/default-cover.jpg') }}" alt="Portada no disponible">
                                @endif
                            </div>
                            <h4>{{ $libro->titulo }} <span>{{ $libro->editorial->nombre ?? 'Editorial no disponible' }}</span></h4>
                            <p><strong>Autores:</strong>
                                @if ($libro->autores->isNotEmpty())
                                {{ $libro->autores->pluck('nombre')->join(', ') }}
                                @else
                                No disponible
                                @endif
                            </p>
                            <p><strong>Ejemplares disponibles:</strong>
                                @if ($libro->ejemplares->isNotEmpty())
                                {{ $libro->ejemplares->where('estado', 'disponible')->count() }} disponibles
                                @else
                                No disponible
                                @endif
                            </p>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
        </section>

        <!-- Venue Section -->
        <section id="cbtis" class="venue section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Biblioteca Escolar Plus<br></h2>
                <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
            </div><!-- End Section Title -->

            <div class="container-fluid" data-aos="fade-up">

                <div class="row g-0">
                    <div class="col-lg-6 venue-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3212.091050338025!2d-96.66869377079811!3d16.784557944547533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85c740b422dd5e33%3A0x76b5a9085a9299ba!2sC.B.T.I.S%20150!5e0!3m2!1ses-419!2smx!4v1731465161449!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="col-lg-6 venue-info">
                        <div class="row justify-content-center">
                            <div class="col-11 col-lg-8 position-relative">
                                <h3>CBTis 150</h3>
                                <p>Aquí encontraras mas libros en físico.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container-fluid venue-gallery-container" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-0">

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="assets/img/venue-gallery/img1.jpg" class="glightbox" data-gall="venue-gallery">
                                <img src="assets/img/venue-gallery/img1.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="assets/img/venue-gallery/img2.jpg" class="glightbox" data-gall="venue-gallery">
                                <img src="assets/img/venue-gallery/img2.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="assets/img/venue-gallery/img3.jpg" class="glightbox" data-gall="venue-gallery">
                                <img src="assets/img/venue-gallery/img3.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="assets/img/venue-gallery/img4.jpg" class="glightbox" data-gall="venue-gallery">
                                <img src="assets/img/venue-gallery/img4.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="assets/img/venue-gallery/img5.jpg" class="glightbox" data-gall="venue-gallery">
                                <img src="assets/img/venue-gallery/img5.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="assets/img/venue-gallery/img6.jpg" class="glightbox" data-gall="venue-gallery">
                                <img src="assets/img/venue-gallery/img6.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="venue-gallery">
                            <a href="assets/img/venue-gallery/img7.jpg" class="glightbox" data-gall="venue-gallery">
                                <img src="assets/img/venue-gallery/img7.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </section><!-- /Venue Section -->

        <section id="recomendado" class="hotels section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Libros Recomendados</h2>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    @foreach ($librosRecomendados as $libro)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card h-100">
                            <div class="card-img">
                                @if ($libro->imagen_portada)
                                <img src="{{ asset($libro->imagen_portada) }}" alt="Portada de {{ $libro->titulo }}" class="img-fluid">
                                @else
                                <img src="{{ asset('img/default-cover.jpg') }}" alt="Portada no disponible" class="img-fluid">
                                @endif
                            </div>
                            <h3><a class="stretched-link">{{ $libro->titulo }}</a></h3>
                            <p><strong>Autores:</strong>
                                @if ($libro->autores->isNotEmpty())
                                {{ $libro->autores->pluck('nombre')->join(', ') }}
                                @else
                                No disponible
                                @endif
                            </p>
                        </div>
                    </div><!-- End Card Item -->
                    @endforeach
                </div>
            </div>

        </section><!-- /Libros Recomendados Section -->

        <!-- Faq Section -->
        <section id="faq" class="faq section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Preguntas frecuentes</h2>
                <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

                        <div class="faq-container">

                            <div class="faq-item faq-active">
                                <h3>¿Cómo puedo rentar un libro?</h3>
                                <div class="faq-content">
                                    <p>Para rentar un libro, debes registrarte en nuestra página web, buscar el libro que deseas y seleccionarlo. Una vez confirmado, el libro será apartado para ti.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>¿Cuántos libros puedo rentar al mismo tiempo?</h3>
                                <div class="faq-content">
                                    <p>Puedes rentar hasta un máximo de 3 libros al mismo tiempo.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>¿Cuánto tiempo puedo quedarme con un libro rentado?</h3>
                                <div class="faq-content">
                                    <p>El tiempo máximo para devolver un libro es de 5 días.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>¿Cómo devuelvo un libro rentado?</h3>
                                <div class="faq-content">
                                    <p>Para devolver un libro, inicia sesión en tu cuenta, selecciona la opción de "Devolver libro". Asegúrate de realizar la devolución dentro del plazo establecido.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>¿Qué pasa si no devuelvo un libro a tiempo?</h3>
                                <div class="faq-content">
                                    <p>Si no devuelves un libro dentro de los 5 días permitidos, la opción de 'Ver Libro' no estara disponible y solo se te va a recargar la página. Te recomendamos devolverlo a tiempo para evitar sanciones como el bloqueo de tu cuenta.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>¿Puedo renovar la renta de un libro?</h3>
                                <div class="faq-content">
                                    <p>Sí, puedes renovar la renta de un libro siempre y cuando no haya sido reservado por otro usuario. La renovación se realizara devolviendo el libro y rentandolo de nuevo.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>

                    </div><!-- End Faq Column-->

                </div>

            </div>

        </section><!-- /Faq Section -->

        <!-- modales seccion  -->
        <!-- perfil  -->
        <!-- Modal -->
        <div class="modal  fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Mis Libros Prestados</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Mostrar libros prestados actualmente -->
                        <h5>Libros Actuales:</h5>
                        <ul>
                            @foreach($prestamosActivos as $prestamo)
                            <li>
                                <strong>{{ $prestamo->ejemplares->first()->libro->titulo }}</strong> - Fecha de devolución: {{ $prestamo->fecha_devolucion_pactada }}
                                <div>
                                    <a href="{{ route('ver.pdf', ['id' => $prestamo->id]) }}" class="btn btn-info btn-sm" target="_blank">Ver Libro</a>
                                    <form action="{{ route('devolver.libro', ['id' => $prestamo->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Devolver Libro</button>
                                    </form>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <!-- Mostrar historial de préstamos -->
                        <h5>Historial de Préstamos:</h5>
                        <ul>
                            @foreach($historialPrestamos as $historial)
                            <li>
                                <strong>{{ $historial->ejemplar->libro->titulo }}</strong> - Fecha de préstamo: {{ $historial->fecha_inicio }} - Fecha de devolución: {{ $historial->fecha_devolucion }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agregar SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('
                    success ') }}',
                });
                @endif
            });
        </script>
        <!-- fin perfil  -->
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Rentar un libro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tiene un plazo de 5 días para devolver el libro, de lo contrario se te sancionará. Al terminar el proceso de renta, cuando se actualize la página podras ver en tu perfil tu libro.</p>
                        <form action="{{ route('rentar') }}" method="POST" id="rentarForm">
                            @csrf
                            <p>Seleccione los libros que desea rentar (máximo 3 a la vez):</p>
                            <ul>
                                @foreach ($ejemplaresDisponibles as $ejemplar)
                                <li>
                                    <input type="checkbox" name="ejemplares[]" value="{{ $ejemplar->id }}" id="ejemplar-{{ $ejemplar->id }}" class="ejemplar-checkbox"
                                        data-book-title="{{ $ejemplar->libro->titulo }}"
                                        data-book-authors="{{ $ejemplar->libro->autores->pluck('nombre')->join(', ') }}">
                                    <label for="ejemplar-{{ $ejemplar->id }}">{{ $ejemplar->libro->titulo }} - {{ $ejemplar->libro->autores->pluck('nombre')->join(', ') }}</label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.ejemplar-checkbox');
                const maxSeleccion = @json($maxSeleccion); // Aseguramos que maxSeleccion se pase correctamente

                let selectedCount = 0;

                // Función para manejar la selección de casillas
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            selectedCount++;
                        } else {
                            selectedCount--;
                        }
                    });
                });

                // Validación antes de enviar el formulario
                const form = document.getElementById('rentarForm');
                form.addEventListener('submit', function(event) {
                    if (selectedCount > maxSeleccion) {
                        event.preventDefault(); // Prevenir el envío del formulario si se excede el límite
                        Swal.fire({
                            icon: 'error',
                            title: '¡Límite excedido!',
                            text: 'Solo puedes seleccionar hasta ' + maxSeleccion + ' libros.',
                        });
                    }
                });
            });
        </script>

        @auth
        <!-- Modal de Bootstrap para Administrar Libros -->
        <div class="modal fade" id="adminLibrosModal" tabindex="-1" aria-labelledby="adminLibrosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminLibrosModalLabel">Administración - (!Este apartado aun esta en construcción y pruebas, puede presentar errores¡)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Estamos trabajando para mejorar esta sección.</p>
                        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="libros-tab" data-bs-toggle="tab" data-bs-target="#libros" type="button" role="tab">Libros</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="autores-tab" data-bs-toggle="tab" data-bs-target="#autores" type="button" role="tab">Autores</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="editoriales-tab" data-bs-toggle="tab" data-bs-target="#editoriales" type="button" role="tab">Editoriales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="informes-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button" role="tab">Inventario</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="adminTabsContent">
                            <!-- Modal de Administrar Libros -->
                            <div class="tab-pane fade" id="libros" role="tabpanel">
                                <div id="librosTableBody">
                                    <!-- Los libros se cargarán aquí dinámicamente como formularios -->
                                </div>
                                <button class="btn btn-primary btn-sm" id="btnAddLibro">Agregar Libro</button>
                            </div>
                            <div class="tab-pane fade" id="autores" role="tabpanel">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Administrar Autores</h5>
                                    <button class="btn btn-primary btn-sm" id="btnAddAutor">Agregar Autor</button>
                                </div>
                                <div id="autoresTableBody">
                                    <!-- Contenido dinámico cargado por JavaScript -->
                                </div>
                            </div>
                            <div class="tab-pane fade" id="editoriales" role="tabpanel">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Administrar Editoriales</h5>
                                    <button class="btn btn-primary btn-sm" id="btnAddEditorial">Agregar Editorial</button>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                            <th>Correo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="editorialesTableBody">
                                        <!-- Contenido dinámico cargado por JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="inventario" role="tabpanel">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Inventario</h5>
                                    <button class="btn btn-primary btn-sm" id="btnGenerarReporte">Generar Reporte</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>
            document.getElementById('btnGenerarReporte').addEventListener('click', () => {
                fetch('/informes/generar-reporte', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('No se pudo generar el reporte.');
                        }
                        return response.blob(); // Procesa la respuesta como un archivo binario
                    })
                    .then(blob => {
                        // Crea un enlace para descargar el archivo
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'reporte_inventario.pdf'; // Nombre del archivo para descargar
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                    })
                    .catch(error => {
                        alert('Error al generar el reporte: ' + error.message);
                        console.error(error);
                    });
            });


            document.addEventListener('DOMContentLoaded', function() {
                const editorialesTableBody = document.getElementById('editorialesTableBody');
                const btnAddEditorial = document.getElementById('btnAddEditorial');

                // Función para cargar editoriales
                const cargarEditoriales = async () => {
                    const response = await fetch('/editoriales/all');
                    const editoriales = await response.json();
                    editorialesTableBody.innerHTML = '';
                    editoriales.forEach(editorial => {
                        editorialesTableBody.innerHTML += `
                <tr>
                    <td>${editorial.nombre}</td>
                    <td>${editorial.direccion || 'N/A'}</td>
                    <td>${editorial.telefono || 'N/A'}</td>
                    <td>${editorial.correo || 'N/A'}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarEditorial(${editorial.id})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarEditorial(${editorial.id})">Eliminar</button>
                    </td>
                </tr>
            `;
                    });
                };

                // Función para agregar editorial
                btnAddEditorial.addEventListener('click', () => {
                    const nombre = prompt('Ingrese el nombre de la editorial:');
                    if (!nombre) return;

                    const datos = {
                        nombre
                    };
                    fetch('/editoriales/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(datos),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Editorial creada correctamente.');
                                cargarEditoriales();
                            } else {
                                alert(data.message || 'Error al crear la editorial.');
                            }
                        });
                });

                // Función para editar editorial
                window.editarEditorial = id => {
                    const nombre = prompt('Ingrese el nuevo nombre de la editorial:');
                    if (!nombre) return;

                    const datos = {
                        id,
                        nombre
                    };
                    fetch('/editoriales/update', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(datos),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Editorial actualizada correctamente.');
                                cargarEditoriales();
                            } else {
                                alert(data.message || 'Error al actualizar la editorial.');
                            }
                        });
                };

                // Función para eliminar editorial
                window.eliminarEditorial = id => {
                    if (!confirm('¿Está seguro de eliminar esta editorial?')) return;

                    fetch('/editoriales/destroy', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                id
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Editorial eliminada correctamente.');
                                cargarEditoriales();
                            } else {
                                alert(data.message || 'Error al eliminar la editorial.');
                            }
                        });
                };

                // Cargar editoriales al abrir el modal
                document.getElementById('editoriales-tab').addEventListener('shown.bs.tab', cargarEditoriales);
            });

            document.addEventListener('DOMContentLoaded', function() {

                const autoresTableBody = document.getElementById('autoresTableBody');
                const btnAddAutor = document.getElementById('btnAddAutor');

                // Función para cargar los autores
                const cargarAutores = async () => {
                    try {
                        const response = await fetch('/autores/all');
                        const autores = await response.json();
                        autoresTableBody.innerHTML = '';
                        autores.forEach(autor => {
                            autoresTableBody.innerHTML += `
            <div class="d-flex mb-3" id="autor-${autor.id}">
                <input type="text" class="form-control me-2" id="nombre-${autor.id}" value="${autor.nombre}" placeholder="Nombre" required>
                <input type="text" class="form-control me-2" id="apellido_paterno-${autor.id}" value="${autor.apellido_paterno}" placeholder="Apellido Paterno">
                <input type="text" class="form-control me-2" id="apellido_materno-${autor.id}" value="${autor.apellido_materno}" placeholder="Apellido Materno">
                <button class="btn btn-warning btn-sm me-2" onclick="editarAutor(${autor.id})">Actualizar</button>
                <button class="btn btn-danger btn-sm" onclick="eliminarAutor(${autor.id})">Eliminar</button>
            </div>
            `;
                        });
                    } catch (error) {
                        alert('Error al cargar los autores');
                    }
                };

                // Mostrar el modal para agregar un autor
                document.getElementById('btnAddAutor').addEventListener('click', () => {
                    const nombre = prompt('Ingrese el nombre del autor:');
                    if (!nombre) return;

                    const datos = {
                        nombre
                    };

                    fetch('/autores/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                nombre,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert('Autor agregado correctamente.');
                            cargarAutores(); // Recargar la lista de autores
                        })
                        .catch(error => {
                            alert('Error al agregar autor');
                            console.error(error);
                        });

                });

                // Función para editar un autor
                window.editarAutor = (id) => {
                    const nombre = document.getElementById(`nombre-${id}`).value;
                    const apellidoPaterno = document.getElementById(`apellido_paterno-${id}`).value;
                    const apellidoMaterno = document.getElementById(`apellido_materno-${id}`).value;

                    fetch('/autores/update', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                id,
                                nombre,
                                apellido_paterno: apellidoPaterno,
                                apellido_materno: apellidoMaterno
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Autor actualizado correctamente.');
                                cargarAutores();
                            } else {
                                alert(data.message || 'Error al actualizar el autor.');
                            }
                        });
                };

                // Función para eliminar un autor
                window.eliminarAutor = (id) => {
                    if (confirm('¿Está seguro de eliminar este autor?')) {
                        fetch('/autores/destroy', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    id
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Autor eliminado correctamente.');
                                    cargarAutores();
                                } else {
                                    alert(data.message || 'Error al eliminar el autor.');
                                }
                            })
                            .catch(error => alert('Error al eliminar el autor'));
                    }
                };

                // Cargar autores cuando se abre la pestaña del modal
                document.getElementById('autores-tab').addEventListener('shown.bs.tab', cargarAutores);

                // Cargar la lista inicial de autores
                cargarAutores();
            });

            document.addEventListener('DOMContentLoaded', function() {
                const librosTableBody = document.getElementById('librosTableBody');
                const btnAddLibro = document.getElementById('btnAddLibro');

                // Función para cargar los libros
                const cargarLibros = async () => {
                    try {
                        const response = await fetch('/libros/all');
                        const libros = await response.json();
                        librosTableBody.innerHTML = '';

                        libros.forEach(libro => {
                            // Crear formulario para cada libro
                            librosTableBody.innerHTML += `
                <div class="d-flex mb-3" id="libro-${libro.id}">
                    <input type="text" class="form-control me-2" id="titulo-${libro.id}" value="${libro.titulo}" placeholder="Título" required>
                    <select class="form-control me-2" id="editorial-${libro.id}">
                        <option value="">Seleccionar Editorial</option>
                        <!-- Las editoriales se cargarán aquí -->
                    </select>
                    <select class="form-control me-2" id="autor-${libro.id}">
                        <option value="">Seleccionar Autor</option>
                        <!-- Los autores se cargarán aquí -->
                    </select>
                    <input type="text" class="form-control me-2" id="codigo-${libro.id}" value="${libro.codigo}" placeholder="Código" required>
                    <button class="btn btn-warning btn-sm me-2" onclick="editarLibro(${libro.id})">Actualizar</button>
                    <button class="btn btn-danger btn-sm" onclick="eliminarLibro(${libro.id})">Eliminar</button>
                </div>
                `;
                            // Cargar las editoriales y autores al formulario
                            cargarEditoriales(libro.id);
                            cargarAutores(libro.id);
                        });
                    } catch (error) {
                        alert('Error al cargar los libros');
                    }
                };

                // Función para cargar las editoriales en el select
                const cargarEditoriales = async (libroId) => {
                    try {
                        const response = await fetch('/editoriales/all');
                        const editoriales = await response.json();
                        const selectEditorial = document.getElementById(`editorial-${libroId}`);

                        editoriales.forEach(editorial => {
                            const option = document.createElement('option');
                            option.value = editorial.id;
                            option.textContent = editorial.nombre;
                            selectEditorial.appendChild(option);
                        });
                    } catch (error) {
                        alert('Error al cargar las editoriales');
                    }
                };

                // Función para cargar los autores en el select
                const cargarAutores = async (libroId) => {
                    try {
                        const response = await fetch('/autores/all');
                        const autores = await response.json();
                        const selectAutor = document.getElementById(`autor-${libroId}`);

                        autores.forEach(autor => {
                            const option = document.createElement('option');
                            option.value = autor.id;
                            option.textContent = autor.nombre;
                            selectAutor.appendChild(option);
                        });
                    } catch (error) {
                        alert('Error al cargar los autores');
                    }
                };

                // Función para editar un libro
                window.editarLibro = (id) => {
                    const titulo = document.getElementById(`titulo-${id}`).value;
                    const editorialId = document.getElementById(`editorial-${id}`).value;
                    const autorId = document.getElementById(`autor-${id}`).value;
                    const codigo = document.getElementById(`codigo-${id}`).value;

                    // Enviar los datos al servidor para actualizar el libro
                    fetch('/libros/update', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                id,
                                titulo,
                                editorial_id: editorialId,
                                autor_id: autorId,
                                codigo
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Libro actualizado correctamente.');
                                cargarLibros();
                            } else {
                                alert('Error al actualizar el libro.');
                            }
                        });
                };

                // Función para eliminar un libro
                window.eliminarLibro = (id) => {
                    if (confirm('¿Está seguro de eliminar este libro?')) {
                        fetch('/libros/destroy', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify({
                                    id
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Libro eliminado correctamente.');
                                    cargarLibros();
                                } else {
                                    alert('Error al eliminar el libro.');
                                }
                            });
                    }
                };

                // Mostrar el modal para agregar un libro
                btnAddLibro.addEventListener('click', () => {
                    const nombre = prompt('Ingrese el nombre del libro:');
                    if (!nombre) return;

                    const datos = {
                        nombre
                    };
                    fetch('/libros/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(datos)
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert('Libro agregado correctamente.');
                            cargarLibros();
                        })
                        .catch(error => {
                            alert('Error al agregar el libro.');
                            console.error(error);
                        });
                });

                // Cargar los libros cuando se abre la pestaña
                document.getElementById('libros-tab').addEventListener('shown.bs.tab', cargarLibros);

                // Cargar la lista de libros al cargar la página
                cargarLibros();
            });
        </script>
        @endauth

        <!-- fin modales seccion  -->
    </main>

    <footer id="footer" class="footer dark-background">

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6 footer-about">
                        <a href="index.html" class="logo d-flex align-items-center">
                            <span class="sitename">BiblioPlus</span>
                        </a>
                        <div class="footer-contact pt-3">
                            <p>CBTis 150</p>
                            <p>Ocotlán, Oaxaca CP: 71510</p>
                            <p class="mt-3"><strong>Teléfono:</strong> <span> +52 951 571 0633
                                </span></p>
                            <p><strong>Correo:</strong> <span> cbtis150.dir@dgeti.sems.gob.mx</span></p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Terms of service</a></li>
                            <li><a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="copyright text-center">
            <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div>
                        © Copyright <strong><span>MyWebsite</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href="https://www.facebook.com/cbtis150cmb "><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                </div>

            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>
    No code was selected to improve.

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>