@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<!-- Header Icon -->
<div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-700 text-lg">
    <i class="fa-solid fa-key text-slate-800"></i>
</div>

<div class="text-center mb-6">
    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Forgot Password?</h2>
    <p class="text-xs text-slate-500 mt-1 max-w-[280px] mx-auto leading-relaxed">
        Enter your registered email address and we'll send you a password reset link.
    </p>
</div>

<form action="{{ route('password.email') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Email Address -->
    <div>
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
                   placeholder="Registered Email"
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-100/90 border @error('email') border-rose-400 @else border-slate-200/80 @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-hidden focus:ring-2 focus:ring-slate-900/15 focus:bg-white focus:border-slate-300 transition">
        </div>
        @error('email')
            <p class="mt-1.5 text-xs text-rose-500 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-semibold rounded-xl text-sm shadow-md shadow-slate-900/15 transition duration-150 flex items-center justify-center space-x-2 mt-2">
        <span>Send Reset Link</span>
    </button>
</form>

<!-- Back to Login -->
<div class="mt-5 pt-4 border-t border-slate-200/80 text-center">
    <a href="{{ route('login') }}" class="text-xs text-slate-600 hover:text-slate-900 font-semibold transition inline-flex items-center">
        <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Sign In
    </a>
</div>
@endsection
