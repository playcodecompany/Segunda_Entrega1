@extends('layouts.app')

@section('title', __('login.title'))

@section('content')
<div class="contenedor-registro my-5">
    <h2 class="titulo mb-4">{{ __('login.heading') }}</h2>

    @if(session('mensaje'))
        <div class="alerta alert-warning">{{ session('mensaje') }}</div>
    @endif

    @if($errors->any())
        <div class="alerta alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   <form method="POST" action="{{ route('login.store') }}" class="formulario-registro col-md-6 mx-auto">
    @csrf
    
        <div class="mb-3">
            <label for="correo" class="etiqueta">{{ __('login.email_label') }}</label>
            <input type="email" name="correo" id="correo" class="campo-texto" required value="{{ old('correo') }}">
        </div>

        <div class="mb-3">
            <label for="contrasena" class="etiqueta">{{ __('login.password_label') }}</label>
            <input type="password" name="contrasena" id="contrasena" class="campo-texto" required>
        </div>

        <button type="submit" class="boton-registrar">{{ __('login.login_button') }}</button>
        <a href="{{ url('/registro') }}" class="ms-3">{{ __('login.register_link') }}</a>
    </form>
</div>
@endsection
