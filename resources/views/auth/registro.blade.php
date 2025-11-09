@extends('layouts.app')

@section('title', __('registro.title'))

@section('content')
<div class="contenedor-registro my-5">
    <h2 class="titulo mb-4">{{ __('registro.heading') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('registro.store') }}" class="formulario-registro col-md-6 mx-auto">
        @csrf

        <div class="mb-3">
            <label for="name" class="etiqueta">{{ __('registro.name_label') }}</label>
            <input type="text" name="name" id="name" class="campo-texto @error('name') is-invalid @enderror" required value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="etiqueta">{{ __('registro.email_label') }}</label>
            <input type="email" name="email" id="email" class="campo-texto @error('email') is-invalid @enderror" required value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="etiqueta">{{ __('registro.password_label') }}</label>
            <input type="password" name="password" id="password" class="campo-texto @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="etiqueta">{{ __('registro.confirm_password_label') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="campo-texto" required>
        </div>

        <button type="submit" class="boton-registrar">{{ __('registro.register_button') }}</button>
        <a href="{{ url('/iniciosesion') }}" class="ms-3">{{ __('registro.login_link') }}</a>
    </form>
</div>
@endsection
