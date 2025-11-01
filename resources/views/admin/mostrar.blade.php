@extends('layouts.app')

@section('title', 'Detalle Usuario')

@section('content')
<div class="container my-4">
    <h1>Detalle del Usuario</h1>

    <div class="mb-3">
        <strong>ID:</strong> {{ $usuario->id }}
    </div>
    <div class="mb-3">
        <strong>Nombre:</strong> {{ $usuario->name }}
    </div>
    <div class="mb-3">
        <strong>Email:</strong> {{ $usuario->email }}
    </div>
    <div class="mb-3">
        <strong>Creado el:</strong> {{ $usuario->created_at->format('d/m/Y') }}
    </div>

    <a href="{{ route('admin') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
