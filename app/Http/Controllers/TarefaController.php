<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTarefaRequest;
use App\Models\Projeto;
use App\Models\Tarefa;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Tarefa::with([
            'user:id,name',              // criador da tarefa
            'projeto:id,nome,slug',    // projeto
            'usuarios:id,name'           // usuários atribuídos
        ]);



        if ($request->filled('tipo')) {

            // Tarefas criadas por mim
            if ($request->tipo === 'minhas') {
                $query->where('user_id', $user->id);
            }

            // Tarefas onde fui selecionado (many-to-many)
            if ($request->tipo === 'atribuidas') {
                $query->whereHas('usuarios', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
            }
        }


        // filtros meus, projeto.
        if ($request->filled('meus')) {
            $query->whereHas('usuarios', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }


        if ($request->filled('projeto')) {
            $query->where('projeto_id', $request->projeto);
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }


        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        $tarefas = $query
            ->orderBy('created_at', 'desc')
            ->paginate(4)
            ->withQueryString();

        return Inertia::render('Public/Tarefas/TarefaList', [
            'tarefas' => $tarefas,
            'filtros' => $request->only([
                'search',
                'status',
                'prioridade',
                'projeto',
                'tipo'
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Projeto $projeto)
    {

        $usuarios = User::select('id', 'name')->get();

        return Inertia::render('Public/Tarefas/TarefaCreate', [
            'projeto' => $projeto,
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTarefaRequest $request, Projeto $projeto)
    {
        try {

            $dados = $request->validated();

            $dados['slug'] = Str::slug($dados['titulo']);
            $dados['user_id'] = Auth::id(); // criador da tarefa
            $dados['projeto_id'] = $request->projeto_id;

            $tarefa = Tarefa::create($dados);


            if ($request->filled('usuarios')) {
                $tarefa->usuarios()->sync($request->usuarios);
            }

            //$projeto = Projeto::findOrFail($request->projeto_id);

            return redirect()
                ->route('tarefa.list')
                ->with('success', 'Tarefa criada com sucesso!');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Erro ao criar a tarefa.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        $tarefa->load([
            'usuarios:id,name',
            'projeto:id,nome,slug',
            'user:id,name', // criador da tarefa (opcional, mas útil)
        ]);

        return Inertia::render('Public/Tarefas/TarefaEdit', [
            'tarefa' => $tarefa,
            'usuarios' => User::select('id', 'name', 'cargo', 'avatar')->get(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
