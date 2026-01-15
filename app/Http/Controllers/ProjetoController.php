<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjetoRequest;
use App\Http\Requests\UpdateProjetoRequest;
use App\Http\Requests\UpdateTarefaRequest;
use App\Models\Projeto;
use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Projeto::with([
            'user:id,name,slug',
            'tarefas:id,projeto_id,titulo,status,slug',
        ])
            ->withCount('tarefas')
            ->where(function ($q) use ($user) {
                $q->where('visibilidade', 'publico') // todos veem públicos
                    ->orWhere(function ($q2) use ($user) {
                        if ($user) {
                            $q2->where('visibilidade', 'privado')
                                ->where('user_id', $user->id); // privados só do dono
                        }
                    });
            });


        // FILTRO: busca por nome/título
        if ($request->filled('search')) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        // FILTRO: prioridade
        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        // FILTRO: visibilidade
        if ($request->filled('visibilidade')) {
            $query->where('visibilidade', $request->visibilidade);
        }

        // FILTRO:  (todos / meus projetos)
        if ($request->filled('autor')) {
            if ($request->autor === 'meus' && $user) {
                $query->where('user_id', $user->id);
            }
        }

        // Ordenação e paginação
        $projetos = $query->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        return Inertia::render('Public/Projetos/ProjetoList', [
            'projetos' => $projetos,
            'filtros' => $request->only('search', 'prioridade', 'visibilidade', 'autor'),
        ]);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Public/Projetos/ProjetoCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjetoRequest $request)
    {
        try {

            $data = $request->validated();

            $data['slug'] = Str::slug($data['nome']);
            $data['user_id'] = Auth::user()->id;

            Projeto::create($data);

            return redirect()->route('projetos.index')->with('success', 'Projeto criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar o projeto: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projeto $projeto)
    {


        return Inertia::render('Public/Projetos/ProjetoEdit', [
            'projeto' => $projeto,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjetoRequest $request, Projeto $projeto)
    {
        try {
            $data = $request->validated();

            $data['slug'] = Str::slug($data['nome']);

            $projeto->update($data);

            return redirect()->route('projetos.index')->with('success', 'Projeto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o projeto: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {
        try {
            $projeto->delete();

            return redirect()->route('projetos.index')
                ->with('success', 'Projeto deletado com sucesso!');
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Erro ao deletar o projeto.');
        }
    }
}
