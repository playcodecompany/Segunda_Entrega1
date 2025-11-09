<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /** Mostrar formulario de login de jugadores */
    public function showLogin()
    {
        return view('auth.iniciosesion');
    }

    /** Procesar login de jugadores */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ], [
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ingresar un correo válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ]);

        $credentials = [
            'email' => $request->correo,
            'password' => $request->contrasena,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home'); // Redirige a crear partida
        }

        return back()->withErrors([
            'correo' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('correo');
    }

    /** Procesar login de admin */
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ], [
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ingresar un correo válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ]);

        $credentials = [
            'email' => $request->correo,
            'password' => $request->contrasena,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->rol === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('admin');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'correo' => 'No tiene permisos de administrador.',
                ])->onlyInput('correo');
            }
        }

        return back()->withErrors([
            'correo' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('correo');
    }

    /** Logout para todos */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
