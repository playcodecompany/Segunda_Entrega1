@extends('layouts.app') 

@section('title', __('admin.user_detail_title'))

@section('content')
<div class="detalle-usuario">
    <h1>{{ __('admin.user_detail_title') }}</h1>

    <div class="info-usuario">
        <div class="mb-3">
            <span><strong>{{ __('admin.id') }}:</strong> {{ $usuario->id }}</span>
        </div>
        <div class="mb-3">
            <span><strong>{{ __('admin.name') }}:</strong> {{ $usuario->name }}</span>
        </div>
        <div class="mb-3">
            <span><strong>{{ __('admin.email') }}:</strong> {{ $usuario->email }}</span>
        </div>
        <div class="mb-3">
            <span><strong>{{ __('admin.created_at') }}:</strong> {{ $usuario->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="mb-3">
            <span><strong>Rol:</strong> 
                @if($usuario->rol === 'admin')
                    <span class="rol-badge admin">&#9889; {{ __('admin.admin_role') }}</span>
                @else
                    <span class="rol-badge jugador">&#127793; {{ __('admin.player_role') }}</span>
                @endif
            </span>
        </div>
    </div>

    <a href="{{ route('admin') }}" class="btn btn-secondary">{{ __('admin.back') }}</a>
</div>

@endsection
