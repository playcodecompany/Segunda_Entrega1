@extends('layouts.app')

@section('title', __('crearusuarios.title'))

@section('content')
<div class="container my-4">
    <h1>{{ __('crearusuarios.heading') }}</h1>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('crearusuarios.name_label') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('crearusuarios.email_label') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">{{ __('crearusuarios.role_label') }}</label>
            <select name="rol" class="form-control" required>
                <option value="jugador">{{ __('crearusuarios.role_player') }}</option>
                <option value="admin">{{ __('crearusuarios.role_admin') }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('crearusuarios.password_label') }}</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('crearusuarios.password_confirm_label') }}</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-success">{{ __('crearusuarios.create_button') }}</button>
        <a href="{{ route('admin') }}" class="btn btn-secondary">{{ __('crearusuarios.back_button') }}</a>
    </form>
</div>
@endsection
