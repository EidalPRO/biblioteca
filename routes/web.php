<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\RentaController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');


Route::get('/usuarios/crear-usuario', [AuthController::class, 'crearUsuario'])->name('usuarios.create'); // Ruta para crear un usuario
Route::post('/usuarios', [AuthController::class, 'register'])->name('usuarios.store'); // Ruta para registrar un usuario
// Ruta para iniciar sesión
Route::get('/usuarios/iniciar-sesion', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Ruta para cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::post('/rentar', [RentaController::class, 'rentar'])->name('rentar'); // Registrar el alquiler del libro
    Route::post('/devolver/{id}', [RentaController::class, 'devolverLibro'])->name('devolver.libro');  // Para devolver un libro
    Route::get('/ver-pdf/{id}', [RentaController::class, 'mostrarPdf'])->name('ver.pdf');  // Para ver el PDF
});
