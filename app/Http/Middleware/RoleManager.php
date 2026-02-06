<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     */
public function handle(Request $request, Closure $next, $role): Response
{
    // Pastikan user sudah login dulu sebelum cek role
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Ambil user dan cek field role
    $user = Auth::user();

    if ($user->role !== $role) {
        return redirect()->route('login')->with('error', 'Akses ditolak.');
    }

    return $next($request);
}
}