@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<!-- Header Icon -->
<div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-700 text-lg">
    <i class="fa-solid fa-user-plus text-slate-800"></i>
</div>

<div class="text-center mb-6">
    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Create an account</h2>
    <p class="text-xs text-slate-500 mt-1 max-w-[280px] mx-auto leading-relaxed">
        Join BlogSite by completing the secure registration form.
    </p>
</div>

<form action="{{ route('register') }}" method="POST" class="space-y-3.5">
    @csrf

    <!-- Full Name -->
    <div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-user text-sm"></i>
            </div>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   placeholder="Full Name"
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-100/90 border @error('name') border-rose-400 @else border-slate-200/80 @enderror rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-hidden focus:ring-2 focus:ring-slate-900/15 focus:bg-white focus:border-slate-300 transition">
        </div>
        @error('name')
            <p class="mt-1.5 text-xs text-rose-500 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

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
                   placeholder="Email Address"
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
                   placeholder="Password (min 10 chars)"
                   oninput="checkPasswordRequirements(this.value)"
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

        <!-- Live Password Requirements Checklist -->
        <div class="mt-2.5 p-3 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1 text-xs">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1 flex items-center">
                <i class="fa-solid fa-shield-halved text-indigo-600 mr-1.5"></i> Strict Password Policy:
            </div>
            <div id="rule-length" class="flex items-center text-slate-500 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                <span>At least <strong>10 characters</strong></span>
            </div>
            <div id="rule-upper" class="flex items-center text-slate-500 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                <span>Contains <strong>uppercase letter (A-Z)</strong></span>
            </div>
            <div id="rule-lower" class="flex items-center text-slate-500 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                <span>Contains <strong>lowercase letter (a-z)</strong></span>
            </div>
            <div id="rule-number" class="flex items-center text-slate-500 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                <span>Contains <strong>number (0-9)</strong></span>
            </div>
            <div id="rule-symbol" class="flex items-center text-slate-500 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                <span>Contains <strong>special character (!@#$%^&*)</strong></span>
            </div>
        </div>
    </div>

    <!-- Confirm Password -->
    <div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-shield-check text-sm"></i>
            </div>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   required 
                   placeholder="Confirm Password"
                   class="w-full pl-10 pr-10 py-2.5 bg-slate-100/90 border border-slate-200/80 rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-hidden focus:ring-2 focus:ring-slate-900/15 focus:bg-white focus:border-slate-300 transition">
            <button type="button" 
                    onclick="togglePasswordVisibility('password_confirmation', this)" 
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                <i class="fa-regular fa-eye-slash text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-semibold rounded-xl text-sm shadow-md shadow-slate-900/15 transition duration-150 flex items-center justify-center space-x-2 mt-3">
        <span>Create Account</span>
    </button>
</form>

<!-- Sign In Link -->
<div class="mt-5 pt-4 border-t border-slate-200/80 text-center">
    <p class="text-xs text-slate-500">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-slate-900 hover:text-indigo-600 font-semibold transition ml-1">
            Sign in
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
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }

    function checkPasswordRequirements(password) {
        const rules = [
            { id: 'rule-length', valid: password.length >= 10 },
            { id: 'rule-upper', valid: /[A-Z]/.test(password) },
            { id: 'rule-lower', valid: /[a-z]/.test(password) },
            { id: 'rule-number', valid: /[0-9]/.test(password) },
            { id: 'rule-symbol', valid: /[^A-Za-z0-9]/.test(password) },
        ];

        rules.forEach(rule => {
            const el = document.getElementById(rule.id);
            if (!el) return;
            const icon = el.querySelector('i');

            if (rule.valid) {
                el.className = 'flex items-center text-emerald-600 font-medium transition-colors';
                icon.className = 'fa-solid fa-circle-check text-emerald-500 mr-2 w-3.5 text-center';
            } else {
                el.className = 'flex items-center text-slate-500 transition-colors';
                icon.className = 'fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center';
            }
        });
    }
</script>
@endsection
