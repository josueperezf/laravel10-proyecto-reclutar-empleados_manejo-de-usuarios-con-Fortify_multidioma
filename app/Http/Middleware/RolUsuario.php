<?php

namespace App\Http\Middleware;

use App\Http\Constantes\RolConst;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // si el usuario no es de rol o perfil RECLUTADOR  '2', REDIRECCIONAMOS A ruta raiz

        if (auth()->user()->rol != RolConst::RECLUTADOR) {
            return redirect()->route('home'); // en el web.php debemos tener una ruta con un name igual a 'home'
        }
        return $next($request);
    }
}
