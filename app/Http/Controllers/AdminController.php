<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Cargo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function index()
    {

        return Inertia('/');
    }

    public function create()
    {
        $cargos = Cargo::pluck('nome', 'id');

        return Inertia::render('Admin/User/UserCreate', [
            'cargos' => $cargos,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        try {

            // dd("$request");

            $data = $request->validated();

            $data['slug'] = Str::slug($data['name']);

            // Processar avatar
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            User::create($data);

            return redirect()->route('admin.list.usuarios')
                ->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Erro ao salvar o usuário.')
                ->withInput();
        }
    }


    public function listUsers(Request $request)
    {
        $user_auth = Auth::user();
        $id = $user_auth->id;


        $cargos = Cargo::select('nome', 'id')->get();

        $contarUsuario = User::count();

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
            "contarUsuario" => $contarUsuario,
            "cargos" => $cargos,
        ]);
    }

    public function perfilUser(User $usuario)
    {

        // projetos criados pelo usuário
        $projetosCriados = $usuario->projetosCriados()->count();

        // tarefas criadas pelo usuário
        $tarefasCriadas = $usuario->tarefasCriadas()->count();

        // tarefas atribuídas ao usuário
        $tarefasSelecionadas = $usuario->tarefas()->count();

        return Inertia::render('Public/User/UserPerfil', [
            'user' => $usuario,
            //contagens
            'projetosCriados' => $projetosCriados,
            'tarefasCriadas' => $tarefasCriadas,
            'tarefasSelecionadas' => $tarefasSelecionadas,
        ]);

    }

    public function edit(User $usuario)
    {

        $cargos = Cargo::pluck('nome', 'id');

        return Inertia::render('Public/User/UserEdit', [
            'user' => $usuario,
            'cargos' => $cargos
        ]);
    }

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
                ->route('admin.list.usuarios')
                ->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {

            return back()
                ->with('error', 'Erro ao atualizar o usuário.')
                ->withInput();
        }
    }


    public function destroy(User $usuario)
    {
        try {
            $usuario->delete();

            return redirect()->route('admin.list.usuarios')
                ->with('success', 'Usuário deletado com sucesso!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao deletar o usuário.');
        }
    }
}
