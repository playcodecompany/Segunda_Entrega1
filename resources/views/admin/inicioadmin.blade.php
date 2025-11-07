@extends('layouts.app')

@section('title', __('admin.paneltitle'))

@section('content')
<div class="container my-4">
    <h1>{{ __('admin.paneltitle') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
         <a href="{{ route('usuarios.create') }}" class="btn btn-success">{{ __('admin.create_user') }}</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                  <th>{{ __('admin.id') }}</th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.email') }}</th>
                <th>{{ __('admin.created_at') }}</th>
                <th>{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-primary btn-sm">{{ __('admin.view') }}</a>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">{{ __('admin.edit') }}</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                                {{ __('admin.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('admin.no_users') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
