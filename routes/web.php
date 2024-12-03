<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\RentaController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');

// login register logout
Route::get('/usuarios/crear-usuario', [AuthController::class, 'crearUsuario'])->name('usuarios.create'); // Ruta para crear un usuario
Route::post('/usuarios', [AuthController::class, 'register'])->name('usuarios.store'); // Ruta para registrar un usuario
Route::get('/usuarios/iniciar-sesion', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::post('/rentar', [RentaController::class, 'rentar'])->name('rentar');
    Route::post('/devolver/{id}', [RentaController::class, 'devolverLibro'])->name('devolver.libro');
    Route::get('/ver-pdf/{id}', [RentaController::class, 'mostrarPdf'])->name('ver.pdf');

    Route::post('/libros/store', [LibroController::class, 'store'])->name('libros.store');
    Route::put('/libros/update/{id}', [LibroController::class, 'update'])->name('libros.update');
    Route::delete('/libros/destroy', [LibroController::class, 'destroy'])->name('libros.destroy');
    Route::get('/libros/all', [LibroController::class, 'index'])->name('libros.all');


    Route::post('/autores/store', [AutorController::class, 'store'])->name('autores.store');
    Route::put('/autores/update', [AutorController::class, 'update'])->name('autores.update');
    Route::delete('/autores/destroy', [AutorController::class, 'destroy'])->name('autores.destroy');
    Route::get('/autores/all', [AutorController::class, 'index'])->name('autores.all');

    Route::post('/editoriales/store', [EditorialController::class, 'store'])->name('editoriales.store');
    Route::put('/editoriales/update', [EditorialController::class, 'update'])->name('editoriales.update');
    Route::delete('/editoriales/destroy', [EditorialController::class, 'destroy'])->name('editoriales.destroy');
    Route::get('/editoriales/all', [EditorialController::class, 'index'])->name('editoriales.all');
    Route::get('/editoriales/{id}', [EditorialController::class, 'show'])->name('editoriales.show');

    Route::get('/informes/generar-reporte', [InformeController::class, 'generarReporte'])->name('informes.reporte');

});
