<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Invitacion;
use Symfony\Component\HttpFoundation\Response;

class InvitacionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query('token');

        $invitacion = Invitacion::where('token', $token)->first();

        if(!$invitacion || 
            $invitacion->is_used || 
            now()->greaterThan($invitacion->expired_at)
        ){
            return redirect('/')->withErrors(['token' => 'La invitacion es inválida ha expirado.']);
        }

        // Opcional: guardar la invitación válida en la sesión o compartirla con la vista
        $request->merge([
            'invitacion_valida' => true, 
            'rol_invitado' => $invitacion->role, 
            'token' => $token
        ]);

        return $next($request);
    }
}
