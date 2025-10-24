<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{


    public function index()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        // Validação simples dos campos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        // Tenta autenticar o usuário
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Pega o usuário autenticado
            $user = Auth::user();

            // Verifica se é admin
            if ($user->tipo === 'admin') {
                //dd('User tipo: ' . $user->tipo);
                return to_route('admin.dashboard')->with('success', 'Bem-vindo, administrador!');
            } else {
                return to_route('user.dashboard')->with('success', 'Login realizado com sucesso!');
            }
        }

        // Caso falhe o login
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não conferem.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
