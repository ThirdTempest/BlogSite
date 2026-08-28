@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-white">Welcome Back</h2>
    <p class="text-xs text-slate-300 mt-1">Please enter your credentials to access your account.</p>
</div>

<form action="{{ route('login') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Email Address
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

    <!-- Password -->
    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                Password
            </label>
            <a href="{{ route('password.request') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium transition">
                Forgot password?
            </a>
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-lock text-sm"></i>
            </div>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="••••••••••••"
                   class="w-full pl-10 pr-10 py-2.5 bg-slate-900/60 border @error('password') border-rose-500 @else border-slate-700 @enderror rounded-xl text-white placeholder-slate-500 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <button type="button" 
                    onclick="togglePasswordVisibility('password', this)" 
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200">
                <i class="fa-regular fa-eye text-sm"></i>
            </button>
        </div>
        @error('password')
            <p class="mt-1.5 text-xs text-rose-400 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" 
                   name="remember" 
                   class="w-4 h-4 rounded border-slate-700 bg-slate-900/60 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0">
            <span class="text-xs text-slate-300">Remember me for 30 days</span>
        </label>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition duration-150 transform active:scale-[0.98] flex items-center justify-center space-x-2">
        <span>Sign In</span>
        <i class="fa-solid fa-arrow-right text-xs"></i>
    </button>
</form>

<!-- Register Link -->
<div class="mt-6 pt-5 border-t border-white/10 text-center">
    <p class="text-xs text-slate-300">
        Don't have an account yet? 
        <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition ml-1">
            Create account
        </a>
    </p>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection

