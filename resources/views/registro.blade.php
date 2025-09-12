@extends('layouts.app')

@section('title', 'Registro - PlayCode')

@section('content')
<div class="contenedor-registro my-5">
    <h2 class="titulo mb-4">Registrarse en <span class="play">Play</span><span class="code">Code</span></h2>

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

    <form method="POST" action="{{ url('/registro') }}" class="formulario-registro col-md-6 mx-auto">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="etiqueta">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="campo-texto" required value="{{ old('nombre') }}">
        </div>

        <div class="mb-3">
            <label for="correo" class="etiqueta">Correo electrónico</label>
            <input type="email" name="correo" id="correo" class="campo-texto" required value="{{ old('correo') }}">
        </div>

        <div class="mb-3">
            <label for="contrasena" class="etiqueta">Contraseña</label>
            <input type="password" name="contrasena" id="contrasena" class="campo-texto" required>
        </div>

        <button type="submit" class="boton-registrar">Registrarse</button>
        <a href="{{ url('/iniciosesion') }}" class="ms-3">¿Ya tenés cuenta? Iniciar sesión</a>
    </form>
</div>

@endsection

@section('scripts')
<script>
function cambiarIdioma(lang) {
    if (lang === "en") {
        window.location.href = "{{ url('/registroingles') }}"; 
    } else {
        window.location.href = "{{ url('/registro') }}";
    }
}
</script>

@endsection
