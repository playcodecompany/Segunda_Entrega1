@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="admin-container">
    <h1>Panel de Administración</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Botón para crear usuario --}}
    <div class="acciones">
        <a href="{{ route('usuarios.create') }}" class="btn btn-nuevo"> Crear nuevo usuario</a>
    </div>

    {{-- Tabla de usuarios --}}
    <table class="tabla-usuarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-ver">Ver</a>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-editar">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="form-eliminar">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Eliminar este usuario?')">Borrar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
