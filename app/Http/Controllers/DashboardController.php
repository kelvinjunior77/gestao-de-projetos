<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    
    public function index()
    {
        $projectsCount = Projeto::count();
        $tasksCount = Projeto::withCount('tarefas')->get()->sum('tarefas_count');
        
        $finishedProjectsCount = Projeto::where('status', 'concluido')->count();

        $finishedTasksCount = Projeto::whereHas('tarefas', function ($query) {
            $query->where('status', 'concluido');
        })->count();

        $tarefasRecentes = Projeto::with('tarefas')->get()->pluck('tarefas')->flatten()->sortByDesc('created_at')->take(3);

        return Inertia::render('App', [
            'projectsCount' => $projectsCount,
            'tasksCount' => $tasksCount,
            'finishedProjectsCount' => $finishedProjectsCount,
            'finishedTasksCount' => $finishedTasksCount,
            'tarefasRecentes' => $tarefasRecentes
        ]);
    }
}