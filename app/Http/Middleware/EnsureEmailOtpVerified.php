<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailOtpVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Super Admin accounts bypass OTP verification
        if ($user->isAdmin()) {
            return $next($request);
        }

        if ($request->session()->get('auth.otp_verified') !== true || !$user->isEmailVerified()) {
            return $request->expectsJson()
                ? abort(403, 'Your session requires OTP verification.')
                : redirect()->route('otp.verify');
        }

        return $next($request);
    }
}

