@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-white">Reset Password</h2>
    <p class="text-xs text-slate-300 mt-1">
        Forgot your password? No problem. Enter your registered email address and we'll send you a password reset link.
    </p>
</div>

<form action="{{ route('password.email') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Registered Email Address
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-envelope text-sm"></i>
            </div>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   placeholder="name@example.com"
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border @error('email') border-rose-500 @else border-slate-700 @enderror rounded-xl text-white placeholder-slate-500 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        @error('email')
            <p class="mt-1.5 text-xs text-rose-400 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition duration-150 transform active:scale-[0.98] flex items-center justify-center space-x-2">
        <span>Email Password Reset Link</span>
        <i class="fa-solid fa-paper-plane text-xs"></i>
    </button>
</form>

<!-- Back to Login -->
<div class="mt-6 pt-5 border-t border-white/10 text-center">
    <a href="{{ route('login') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold transition inline-flex items-center">
        <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Sign In
    </a>
</div>
@endsection

