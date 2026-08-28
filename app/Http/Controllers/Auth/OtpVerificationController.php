<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class OtpVerificationController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function show(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // If user is Admin or current session is already OTP verified, proceed to dashboard
        if ($user->isAdmin() || $request->session()->get('auth.otp_verified') === true) {
            return redirect()->route('dashboard');
        }

        // If no OTP exists or current one has expired, generate a new one
        if (!$user->hasValidOtp()) {
            $otp = sprintf('%06d', random_int(100000, 999999));
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            try {
                Mail::to($user->email)->send(new SendOtpMail($user, $otp));
            } catch (\Throwable $e) {
                logger()->warning('Google SMTP SendOtpMail error: ' . $e->getMessage());
            }
        }

        return view('auth.verify-otp', [
            'user' => $user,
            'demo_otp' => $user->otp_code,
        ]);
    }

    /**
     * Verify the submitted OTP code.
     */
    public function verify(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($request->session()->get('auth.otp_verified') === true) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'otp' => ['required', 'string', 'digits:6'],
        ], [
            'otp.required' => 'Please enter the 6-digit verification code.',
            'otp.digits' => 'The verification code must be exactly 6 digits.',
        ]);

        // Check if OTP matches
        if ($user->otp_code !== $request->otp) {
            throw ValidationException::withMessages([
                'otp' => 'The verification code entered is incorrect. Please check and try again.',
            ]);
        }

        // Check if OTP has expired
        if (!$user->hasValidOtp()) {
            throw ValidationException::withMessages([
                'otp' => 'This verification code has expired. Please click "Resend Code" to get a new one.',
            ]);
        }

        // Verification successful
        $user->forceFill([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        $request->session()->put('auth.otp_verified', true);

        return redirect()->route('dashboard')
            ->with('success', "Welcome back, {$user->name}! Verification successful.");
    }

    /**
     * Resend a fresh OTP code to the user.
     */
    public function resend(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($request->session()->get('auth.otp_verified') === true) {
            return redirect()->route('dashboard');
        }

        $otp = sprintf('%06d', random_int(100000, 999999));
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($user->email)->send(new SendOtpMail($user, $otp));
        } catch (\Throwable $e) {
            logger()->warning('Google SMTP SendOtpMail error: ' . $e->getMessage());
        }

        return back()->with('status', 'A new 6-digit verification code has been sent to your email address.');
    }
}

