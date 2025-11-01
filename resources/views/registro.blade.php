@extends('layouts.app')

@section('title', 'Registro - PlayCode')

@section('content')
<div class="contenedor-registro my-5">
    <h2 class="titulo mb-4">Registrarse en <span class="play">Play</span><span class="code">Code</span></h2>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('registro.store') }}" class="formulario-registro col-md-6 mx-auto">
        @csrf

        <div class="mb-3">
            <label for="name" class="etiqueta">Nombre</label>
            <input type="text" name="name" id="name" class="campo-texto @error('name') is-invalid @enderror" required value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="etiqueta">Correo electrónico</label>
            <input type="email" name="email" id="email" class="campo-texto @error('email') is-invalid @enderror" required value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="etiqueta">Contraseña</label>
            <input type="password" name="password" id="password" class="campo-texto @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="etiqueta">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="campo-texto" required>

        </div>

        <button type="submit" class="boton-registrar">Registrarse</button>
        <a href="{{ url('/iniciosesion') }}" class="ms-3">¿Ya tenés cuenta? Iniciar sesión</a>
    </form>
</div>

@endsection
