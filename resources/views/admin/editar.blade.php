@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm rounded-lg mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-white">
            <h2 class="mb-0">Editar Usuario</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label fw-bold">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name', $usuario->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email', $usuario->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-warning px-4">Actualizar</button>
                    <a href="{{ route('admin') }}" class="btn btn-secondary px-4">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
