<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified; // Import middleware Laravel

class ConditionalVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        // Periksa apakah pengguna sudah login
        if (Auth::check()) {
            // Jika pengguna login, panggil middleware EnsureEmailIsVerified
            // Ini akan mengarahkan pengguna ke halaman verifikasi jika email belum diverifikasi
            return (new EnsureEmailIsVerified())->handle($request, $next);
        }

        // Jika pengguna belum login, biarkan request berjalan normal (akses publik)
        return $next($request);
    }
}