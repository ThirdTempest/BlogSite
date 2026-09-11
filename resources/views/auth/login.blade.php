@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<!-- Header Icon -->
<div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-700 text-lg">
    <i class="fa-solid fa-arrow-right-to-bracket text-slate-800"></i>
</div>

<!-- Header Text -->
<div class="text-center mb-6">
    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sign in with email</h2>
    <p class="text-xs text-slate-500 mt-1.5 max-w-[280px] mx-auto leading-relaxed">
        Enter your credentials to access your secure BlogSite account.
    </p>
</div>

<form action="{{ route('login') }}" method="POST" class="space-y-3.5">
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
                   placeholder="Email"
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-100/90 border @error('email') border-rose-400 @else border-slate-200/80 @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-hidden focus:ring-2 focus:ring-slate-900/15 focus:bg-white focus:border-slate-300 transition">
        </div>
        @error('email')
            <p class="mt-1.5 text-xs text-rose-500 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-lock text-sm"></i>
            </div>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="Password"
                   class="w-full pl-10 pr-10 py-2.5 bg-slate-100/90 border @error('password') border-rose-400 @else border-slate-200/80 @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-hidden focus:ring-2 focus:ring-slate-900/15 focus:bg-white focus:border-slate-300 transition">
            <button type="button" 
                    onclick="togglePasswordVisibility('password', this)" 
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                <i class="fa-regular fa-eye-slash text-sm"></i>
            </button>
        </div>
        @error('password')
            <p class="mt-1.5 text-xs text-rose-500 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Forgot Password Link -->
    <div class="text-right">
        <a href="{{ route('password.request') }}" class="text-xs text-slate-500 hover:text-slate-900 font-medium transition">
            Forgot password?
        </a>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-semibold rounded-xl text-sm shadow-md shadow-slate-900/15 transition duration-150 flex items-center justify-center space-x-2 mt-2">
        <span>Get Started</span>
    </button>
</form>

<!-- Social Divider -->
<div class="relative my-5">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-slate-200/80"></div>
    </div>
    <div class="relative flex justify-center text-xs">
        <span class="px-3 bg-white/80 backdrop-blur-xs text-slate-400 text-[11px] font-medium">Or sign in with</span>
    </div>
</div>

<!-- Social Buttons (Google, Facebook, Apple)
<div class="grid grid-cols-3 gap-2.5 mb-2">
    <button type="button" class="flex items-center justify-center py-2.5 px-3 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-xs transition duration-150">
        <svg class="w-4 h-4" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
        </svg>
    </button>
    <button type="button" class="flex items-center justify-center py-2.5 px-3 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-xs transition duration-150">
        <svg class="w-4 h-4 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
    </button>
    <button type="button" class="flex items-center justify-center py-2.5 px-3 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-xs transition duration-150">
        <svg class="w-4 h-4 text-slate-900" fill="currentColor" viewBox="0 0 24 24">
            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.62-.75 1.04-1.8 0.92-2.85-.9.04-2 .6-2.65 1.35-.58.66-1.08 1.73-.95 2.76 1.01.08 2.05-.51 2.68-1.26z"/>
        </svg>
    </button>
</div> -->

<!-- Sign Up Link -->
<div class="text-center pt-3 text-xs text-slate-500">
    Don't have an account? 
    <a href="{{ route('register') }}" class="text-slate-900 hover:text-indigo-600 font-semibold ml-1 transition">
        Sign up
    </a>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>
@endsection
