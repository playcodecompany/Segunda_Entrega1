<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ranking;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    public function index() {
        $usuarios = User::all();
        return view('admin.inicioadmin', compact('usuarios'));
    }

    public function create() {
        return view('admin.crearusuario');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,jugador'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede superar 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo debe ser texto.',
            'email.email' => 'Debe ser un correo válido.',
            'email.max' => 'El correo no puede superar 255 caracteres.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol debe ser admin o jugador.'
        ]);

        $usuario = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol' => $validated['rol']
        ]);

        if($usuario->rol === 'jugador'){
            Ranking::firstOrCreate([
                'jugador_id' => $usuario->id,
                'partidas_jugadas' => 0,
                'partidas_ganadas' => 0,
                'puntos_totales' => 0
            ]);
        }

        return redirect()->route('admin')->with('success','Usuario creado correctamente');
    }

    public function edit($id) {
        $usuario = User::findOrFail($id);
        return view('admin.editar', compact('usuario'));
    }

    public function update(Request $request, $id) {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$id}",
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|in:admin,jugador'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede superar 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo debe ser texto.',
            'email.email' => 'Debe ser un correo válido.',
            'email.max' => 'El correo no puede superar 255 caracteres.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol debe ser admin o jugador.'
        ]);

        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->rol = $validated['rol'];
        if(!empty($validated['password'])){
            $usuario->password = Hash::make($validated['password']);
        }
        $usuario->save();

        return redirect()->route('admin')->with('success','Usuario actualizado correctamente');
    }

    public function show($id) {
        $usuario = User::findOrFail($id);
        return view('admin.mostrar', compact('usuario'));
    }

    public function destroy($id) {
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return redirect()->route('admin')->with('success','Usuario eliminado correctamente');
    }
}
