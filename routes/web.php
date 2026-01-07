<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\TarefaController;
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

    //Projetos
    Route::get('/projetos/lista', [ProjetoController::class, 'index'])->name('projetos.index');
    Route::get('/projeto/criar', [ProjetoController::class, 'create'])->name('projeto.create');
    Route::post('/projeto/criar', [ProjetoController::class, 'store'])->name('projeto.store');

    Route::get('/projeto/editar/{projeto:slug}', [ProjetoController::class, 'edit'])->name('projeto.edit');
    Route::post('/projeto/editar/{projeto}', [ProjetoController::class, 'update'])->name('projeto.update');
    
    Route::delete('/projeto/deletar/{projeto}', [ProjetoController::class, 'destroy'])->name('projeto.delete');
    Route::get('/projeto/{projeto}', [ProjetoController::class, 'show'])->name('projeto.show');

    //Tarefas
    Route::get('/criar/tarefa/{projeto:slug}', [TarefaController::class, 'create'])->name('tarefa.create');
    Route::post('/criar/tarefa', [TarefaController::class, 'store'])->name('tarefa.store');
    Route::get('/lista/tarefas', [TarefaController::class, 'index'])->name('tarefa.list');

    Route::get('/tarefa/editar/{tarefa:slug}', [TarefaController::class, 'edit'])->name('tarefa.edit');
    Route::put('/tarefa/editar/{tarefa}', [TarefaController::class, 'update'])->name('tarefa.update');

    //Route::get('/tarefa/editar/{tarefa:slug}', [ProjetoController::class, 'editarTarefa'])->name('tarefa.edit');
    //Route::post('/tarefa/editar/teste/{tarefa}', [ProjetoController::class, 'updateTarefa'])->name('tarefa.update');

    Route::delete('/tarefa/deletar/{tarefa}', [TarefaController::class, 'destroy'])->name('tarefa.delete');
   

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

    // Cargo

    Route::get("/admin/cadastrar/cargo", [CargoController::class, 'create'])->name('admin.cad.cargo');
    Route::post('/admin/cadastrar/cargo', [CargoController::class, 'store']);
    Route::get('/admin/lista/cargos', [CargoController::class, 'index'])->name('admin.lista.cargos');

    Route::delete('/admin/deletar/cargo/{cargo}', [CargoController::class, 'destroy'])->name('admin.delete.cargo');

    Route::get('/admin/editar/cargo/{cargo}', [CargoController::class, 'edit'])->name('admin.edit.cargo');
    Route::post('/admin/editar/cargo/{cargo}', [CargoController::class, 'update'])->name('admin.update.cargo');
});
