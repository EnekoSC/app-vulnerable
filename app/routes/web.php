<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// landing
Route::get('/', fn () => view('landing'))->name('home');

// auth (montado a mano, sin breeze)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/password/forgot', [AuthController::class, 'showForgot'])->name('password.forgot');
Route::post('/password/forgot', [AuthController::class, 'forgot']);

// redireccion de "volver a la web" que usa marketing
Route::get('/ir', [AuthController::class, 'ir'])->name('ir');

// zona privada
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/perfil/actualizar', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/facturas', [InvoiceController::class, 'index'])->name('facturas.index');
    Route::get('/facturas/{id}', [InvoiceController::class, 'show'])->name('facturas.show');
    Route::get('/facturas/{id}/descargar', [InvoiceController::class, 'download'])->name('facturas.download');

    Route::get('/productos', [ProductController::class, 'index'])->name('productos.index');
    Route::get('/productos/{id}', [ProductController::class, 'show'])->name('productos.show');
    Route::post('/productos/{id}/comentar', [CommentController::class, 'store'])->name('productos.comentar');

    Route::get('/perfil/avatar', [AvatarController::class, 'show'])->name('avatar.show');
    Route::post('/perfil/avatar', [AvatarController::class, 'store'])->name('avatar.store');
    Route::post('/perfil/avatar/importar', [AvatarController::class, 'importar'])->name('avatar.importar');
});

// administracion
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
});
