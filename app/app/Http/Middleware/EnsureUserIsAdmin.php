<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // deja pasar solo a administradores. quien consiga marcarse is_admin=1
        // por su cuenta tambien entra, claro
        if (! Auth::check() || ! Auth::user()->esAdmin()) {
            abort(403, 'Zona reservada al personal de Santa S.L.');
        }

        return $next($request);
    }
}
