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

            if ($userRole === $role) {
                return $next($request);
            }

            switch ($userRole) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'dosen':
                    return redirect()->route('dosen.dashboard');
                case 'mahasiswa':
                    return redirect()->route('mahasiswa.dashboard');
                default:
                    return redirect('/');
            }
        }

        return redirect('/login');
    }
}
