<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia('App');
});

Route::middleware('guest')->group(function () {
   
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});


// Rotas protegidas
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Área do Usuário normal
    Route::middleware(['user'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    });
});

// Área do Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get("/admin/cadastrar/usuario", [AdminController::class, 'create'])->name('admin.cad.usuario');

    Route::post("/admin/cadastrar/usuario", [AdminController::class, 'store'])->name('admin.users.store');

    Route::get("/admin/listar/usuarios", [AdminController::class, 'listUsers'])->name('admin.list.usuarios');
    Route::get("/admin/perfil/usuario/{usuario:slug}", [AdminController::class, 'perfilUser'])->name('admin.perfil.usuario');

    Route::get("/admin/editar/usuario/{usuario:slug}", [AdminController::class, 'edit'])->name('admin.edit.usuario');
});
