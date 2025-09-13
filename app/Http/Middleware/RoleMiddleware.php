<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            // Cek role
            if ($userRole === $role) {
                return $next($request);
            }

            // Jika role tidak sesuai, blokir akses dengan 403
            abort(403, 'Unauthorized action.');
        }

        // Jika user belum login, redirect ke login
        return redirect('/login');
    }
}
