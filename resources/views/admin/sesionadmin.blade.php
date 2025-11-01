@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')

<div class="container mt-5" style="max-width: 400px;">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

```
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('login.admin') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" required>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Recordarme</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Ingresar</button>

    <p class="mt-3 text-center">
        ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a>
    </p>
</form>


</div>
@endsection
