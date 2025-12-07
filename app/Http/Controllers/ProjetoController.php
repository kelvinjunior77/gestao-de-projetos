<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjetoRequest;
use App\Http\Requests\UpdateProjetoRequest;
use App\Models\Projeto;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return Inertia::render('Public/Projetos/ProjetoList');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjetoRequest $request, Projeto $projeto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {
        //
    }
}
