<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {

        if (! Auth::check()) {
            return response()->json([
                'message' => 'Admin Unauthenticated.',
            ], 401);
        }

        $user = Auth::user();

        $isAdmin = $user->roles()
            ->where('ROL_NAME', 'Gestionnaire de site')
            ->exists();

        if (! $isAdmin) {
            return response()->json([
                'message' => 'Forbidden',
            ], 403);
        }

        return $next($request);
    }
}
