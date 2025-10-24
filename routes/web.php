<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia('App');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});


// Rotas protegidas
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Área do Usuário normal
    Route::middleware(['user'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    });
});

// Área do Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
