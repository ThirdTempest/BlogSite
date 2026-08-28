<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check() && session('auth.otp_verified') === true) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::validate($credentials)) {
            $user = User::where('email', $credentials['email'])->first();

            // If user is Admin, bypass OTP verification and log in directly
            if ($user->isAdmin()) {
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();
                $request->session()->put('auth.otp_verified', true);

                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }

            // For regular users, generate and send 6-digit OTP
            $otp = sprintf('%06d', random_int(100000, 999999));
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            // Dispatch OTP Email via SMTP
            try {
                Mail::to($user->email)->send(new SendOtpMail($user, $otp));
            } catch (\Throwable $e) {
                logger()->warning('Google SMTP Login SendOtpMail error: ' . $e->getMessage());
            }

            // Log user in and flag session as pending OTP verification
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            $request->session()->put('auth.otp_verified', false);

            return redirect()->route('otp.verify')
                ->with('status', 'A 6-digit verification code has been sent to your email. Please verify to access your dashboard.');
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'You have been logged out successfully.');
    }
}
