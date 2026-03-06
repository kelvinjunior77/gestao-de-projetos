<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Projeto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index()
    {
        $projectsCount = Projeto::count();
        $tasksCount = Projeto::withCount('tarefas')->get()->sum('tarefas_count');

        $finishedProjectsCount = Projeto::where('status', 'concluido')->count();

        $userCount = User::count();
        //$cargoCount = User::select('cargo')->distinct()->count(); lista cargo selecionado pelo usuario

        $cargoCount = Cargo::count();

        $finishedTasksCount = Projeto::whereHas('tarefas', function ($query) {
            $query->where('status', 'concluido');
        })->count(); 


        $tarefasRecentes = Projeto::with('tarefas.user')->get()->pluck('tarefas')->flatten()->sortByDesc('created_at')->take(3);

        // $notificacoes = Auth::user()->notifications->where('data->expires_at', '>', now())->get();

        // Remove notificações expiradas 
        Auth::user()->notifications()->where('data->expires_at', '<', now())->delete();

        $notificacoes = Auth::user()
            ->notifications()->where('data->expires_at', '>', now())
            ->get();

        return Inertia::render('App', [
            'projectsCount' => $projectsCount,
            'tasksCount' => $tasksCount,
            'finishedProjectsCount' => $finishedProjectsCount,
            'finishedTasksCount' => $finishedTasksCount,
            'tarefasRecentes' => $tarefasRecentes,
            'notificacoes' => $notificacoes,
            'userCount' => $userCount,
            'cargoCount' => $cargoCount,
        ]);
    }
}
