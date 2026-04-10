<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roleNames): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $userRole = Auth::user()->role; 

        $roleMap = [
            'administrator' => 1,
            'pengawas'      => 2,
            'pembeli'       => 3,
        ];
        foreach ($roleNames as $roleName) {
            // Jika mappingnya ada DAN angka user cocok dengan angka mapping
            if (isset($roleMap[$roleName]) && $userRole === $roleMap[$roleName]) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak. Level Anda tidak sesuai.');
    }
}