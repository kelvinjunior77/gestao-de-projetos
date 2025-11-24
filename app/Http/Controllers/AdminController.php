<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function index()
    {

        return Inertia::render('Admin/Dashboard');
    }

    public function create()
    {
        return Inertia::render('Admin/User/UserCreate');
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

        $users = $query->paginate(10)->withQueryString();

        return Inertia::render("Admin/User/UserList", [
            "users" => $users,
            "filters" => $request->only(["search", "cargo", "tipo"]),
        ]);
    }
}
