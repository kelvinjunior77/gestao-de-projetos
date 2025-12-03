<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_auth = Auth::user();
        $id = $user_auth->id;

        $totalUsuarios = User::count();


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
            "totalUsuarios" => $totalUsuarios, 
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
    public function update(UpdateUserRequest $request, User $usuario)
    {
        try {
            $data = $request->validated();


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

            // Senha (somente se foi enviada)
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
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
