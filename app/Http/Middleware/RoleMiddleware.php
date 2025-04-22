<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user(); // Retrieve the authenticated user

        // Ensure user exists and check the user's idRole directly
        if (!$user || !in_array($user->idRole, $roles)) { // Use $roles as an array
            //dd($user ? $user->idRole : 'No authenticated user'); // Debug idRole
            abort(403, 'No autorizado');
        }

        return $next($request);
        //dd($roles);
    }
}
