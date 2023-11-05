<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role == 'client' && auth()->user()->role != 'client' ) {
            abort(403);
        }
        if ($role == 'company' && auth()->user()->role != 'company' ) {
            abort(403);
        }
        return $next($request);
    }
}
