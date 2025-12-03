<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCargoRequest;
use App\Http\Requests\UpdateCargoRequest;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $cargo_total = Cargo::count();

        $query = Cargo::query();

         // Search
        if ($request->search) {
            $query->where('nome', 'like', "%{$request->search}%");
        }

        $cargos = $query->paginate(4)->withQueryString();
        
        return Inertia::render('Admin/Cargo/CargoList',[
            "cargos" => $cargos,
            "filters" => $request->only("search"),
            "cargo_total" => $cargo_total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return Inertia::render('Admin/Cargo/CargoCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCargoRequest $request)
    {
        try {

            // dd("$request");
            $data = $request->validated();

            Cargo::create($data);

            return redirect()->route('admin.lista.cargos')
                ->with('success', 'Cadastrado com sucesso!');
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Erro ao salvar cargo.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cargo $cargo)
    {
        
        return Inertia::render('Admin/Cargo/CargoEdit', [
            'cargo' => $cargo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargoRequest $request, Cargo $cargo)
    {
        try {
            $data = $request->validated();

            $cargo->update($data);

            return redirect()->route('admin.lista.cargos')
                ->with('success', 'Compontencias atualizado com sucesso!');
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Erro ao atualizar o cargo.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        try {
            $cargo->delete();

            return redirect()->route('admin.lista.cargos')
                ->with('success', 'Cargo deletado com sucesso!');
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Erro ao deletar o cargo.');
        }
    }
}
