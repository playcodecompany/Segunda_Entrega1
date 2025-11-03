<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Suponiendo que en tu tabla users hay un campo 'is_admin'
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Si no es admin, redirigir a home o login
        return redirect('/')->with('mensaje', 'No tienes permisos para acceder a esta sección.');
    }
}
