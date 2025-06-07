<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // abort(403, 'Akses ditolak.');
            if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect('/admin');
            } elseif ($user->role === 'penjahit') {
                return redirect('/penjahit');
            } elseif ($user->role === 'user') {
                return redirect('/pelanggan');
            }
        }
        }

        return $next($request);
    }
}
