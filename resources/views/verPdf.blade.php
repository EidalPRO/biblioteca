@extends('layouts.app')

@section('titulo', 'Ver PDF')

@section('nav')
<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="/">Inicio<br></a></li>
        <!-- <li><a href="#speakers">Speakers</a></li> -->
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
@endsection

@section('title-page', 'Ver el libro prestado')

@section('content')
<div class="container">
    <h2>Ver el Libro: {{ $prestamo->ejemplares->first()->libro->titulo }}</h2>

    @if($prestamo->fecha_devolucion_pactada < now())
        <p>El préstamo de este libro ha vencido. Redirigiendo...</p>
        <script>
            setTimeout(function() {
                window.location.href = '/';
            }, 3000);
        </script>
        @else
        <iframe src="{{ asset($pdfPath) }}?t={{ time() }}" width="100%" height="600px" style="border: none;">
            <p>Su navegador no soporta PDFs. <a href="{{ asset($pdfPath) }}">Descargar PDF</a>.</p>
        </iframe>
        @endif
</div>
@endsection