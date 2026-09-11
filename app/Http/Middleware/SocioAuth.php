<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SocioAuth
{
    /**
     * Handle an incoming request for Socio Portal.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('socio_id')) {
            return redirect()->route('portal.login')->with('error', 'Por favor ingrese su código de acceso y fecha de nacimiento para continuar.');
        }

        return $next($request);
    }
}
