<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_auth = Auth::user();
        $id = $user_auth->id;

        $query = User::query();

        // Search
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        // Cargo
        if ($request->cargo) {
            $query->where('cargo', $request->cargo);
        }

        // Tipo
        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        $users = $query->paginate(4)->withQueryString();

        return Inertia::render("Public/User/UserList", [
            "users" => $users,
            "filters" => $request->only(["search", "cargo", "tipo"]),
            "id" => $id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {

        return Inertia::render('Public/User/UserPerfil', [
            'user' => $usuario,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {

        return Inertia::render('Public/User/UserEdit', [
            'user' => $usuario
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $usuario->id,
                'avatar' => 'nullable|image',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'email.required' => 'O campo email é obrigatório.',
                'email.email' => 'Por favor, insira um email válido.',
                'email.unique' => 'Este email já está em uso.',
                'avatar.image' => 'O arquivo enviado deve ser uma imagem.',
            ]);

            // Processar avatar
            if ($request->hasFile('avatar')) {

                // Deleta avatar antigo se existir
                if ($usuario->avatar && Storage::disk('public')->exists($usuario->avatar)) {
                    Storage::disk('public')->delete($usuario->avatar); 
                }

                // Salva novo avatar
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            } else {
                // Mantém o avatar atual
                $data['avatar'] = $usuario->avatar;
            }

            // Atualiza slug
            $data['slug'] = Str::slug($data['name']); 

            // Atualizar usuário
            $usuario->update($data);

            return redirect()
                ->route('usuario.lista')
                ->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Erro ao atualizar o usuário.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
