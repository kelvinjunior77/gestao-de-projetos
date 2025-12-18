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
    public function index()
    {
        //
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

            $projeto = Projeto::findOrFail($request->projeto_id);

            return redirect()
                ->route('tarefa.create', $projeto->slug)
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
    public function edit(string $id)
    {
        //
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
