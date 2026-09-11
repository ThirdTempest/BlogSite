<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'We could not find a user with that email address.',
        ]);

        $token = Str::random(60);

        // Store token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        // Send branded reset password email notification via SMTP
        try {
            $user = User::where('email', $request->email)->first();
            Mail::to($user->email)->send(new \App\Mail\ResetPasswordMail($user, $resetUrl));
        } catch (\Throwable $e) {
            logger()->warning('SMTP ResetPasswordMail error: ' . $e->getMessage());
        }

        return back()->with('status', 'We have emailed your password reset link! Please check your inbox.');
    }
}

