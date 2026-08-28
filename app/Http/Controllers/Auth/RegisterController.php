<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ], [
            'password.min' => 'The password must be at least 10 characters.',
            'password.mixed' => 'The password must contain both uppercase and lowercase letters.',
            'password.symbols' => 'The password must contain at least one special character.',
            'password.numbers' => 'The password must contain at least one number.',
        ]);

        $otp = sprintf('%06d', random_int(100000, 999999));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'email_verified_at' => null,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($user, $otp));
        } catch (\Throwable $e) {
            logger()->warning('Google SMTP SendOtpMail error: ' . $e->getMessage());
        }

        Auth::login($user);
        $request->session()->put('auth.otp_verified', false);

        return redirect()->route('otp.verify')
            ->with('status', 'Registration initiated! Please enter the 6-digit OTP sent to your email to access your dashboard.');
    }
}

