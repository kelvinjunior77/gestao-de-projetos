<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            'password' => ['required', 'min:8'],
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ]);

        // Tenta autenticar o usuário
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            Auth::user()->update([
                'last_login_at' => now(),
            ]);

            // Pega o usuário autenticado
           // $user = Auth::user();

            // Verifica se é admin
            /*
            if ($user->tipo === 'admin') {
                //dd('User tipo: ' . $user->tipo);
                return to_route('admin.dashboard')->with('success', 'Bem-vindo, administrador!');
            } else {
                return to_route('user.dashboard')->with('success', 'Login realizado com sucesso!');
            }*/
            return to_route('dashboard')->with('success', 'Login realizado com sucesso!');
            
        }

        // Caso falhe o login
        return back()->withErrors([
            'mensagem' => 'As credenciais fornecidas não conferem.',
        ])->onlyInput('mensagem');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
