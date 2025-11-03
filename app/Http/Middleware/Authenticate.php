<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Define a qué ruta redirigir si el usuario no está autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Si es una ruta de admin
            if ($request->is('admin/*')) {
                return route('sesionadmin');
            }

            // Para rutas de jugadores normales
            return route('iniciosesion');
        }
    }
}
