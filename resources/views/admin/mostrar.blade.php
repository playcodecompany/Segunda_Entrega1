@extends('layouts.app') 

@section('title', 'Detalle Usuario')

@section('content')
<div class="detalle-usuario">
    <h1>Detalle del Usuario</h1>

    <div class="info-usuario">
        <div class="mb-3">
            <span><strong>ID:</strong> {{ $usuario->id }}</span>
        </div>
        <div class="mb-3">
            <span><strong>Nombre:</strong> {{ $usuario->name }}</span>
        </div>
        <div class="mb-3">
            <span><strong>Email:</strong> {{ $usuario->email }}</span>
        </div>
        <div class="mb-3">
            <span><strong>Creado el:</strong> {{ $usuario->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="mb-3">
            <span><strong>Rol:</strong> 
                @if($usuario->rol === 'admin')
                    <span class="rol-badge admin">&#9889; Admin</span>
                @else
                    <span class="rol-badge jugador">&#127793; Jugador</span>
                @endif
            </span>
        </div>
    </div>

    <a href="{{ route('admin') }}" class="btn btn-secondary">Volver</a>
</div>

@endsection
