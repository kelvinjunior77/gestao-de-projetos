<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});


// Rotas protegidas
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/lista/usuarios', [UserController::class, 'index'])->name('usuario.lista');
    Route::get('/usuario/perfil/{usuario:slug}', [UserController::class, 'show'])->name('usuario.update.perfil');

    Route::get('/usuario/editar/{usuario:slug}', [UserController::class, 'edit'])->name('usuario.edit');
    Route::post('/usuario/editar/{usuario}', [UserController::class, 'update'])->name('usuario.update');


    // Área do Usuário normal
    Route::middleware(['user'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
        //Route::get('/usuario/lista', [UserController::class, 'lista-usuario'])->name('usuario.lista');
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
    Route::post("/admin/editar/usuario/{usuario}", [AdminController::class, 'update'])->name('admin.update.usuario');

    Route::delete("/admin/deletar/usuario/{usuario}", [AdminController::class, 'destroy'])->name('admin.delete.usuario');
});
