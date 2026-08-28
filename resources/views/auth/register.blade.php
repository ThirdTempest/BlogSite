@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-white">Create Account</h2>
    <p class="text-xs text-slate-300 mt-1">Join the system by completing the registration form.</p>
</div>

<form action="{{ route('register') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Full Name -->
    <div>
        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Full Name
        </label>
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
                   placeholder="e.g. John Doe"
                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900/60 border @error('name') border-rose-500 @else border-slate-700 @enderror rounded-xl text-white placeholder-slate-500 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        @error('name')
            <p class="mt-1.5 text-xs text-rose-400 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

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
        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Password
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-lock text-sm"></i>
            </div>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="••••••••••••"
                   oninput="checkPasswordRequirements(this.value)"
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

        <!-- Live Password Requirements Checklist -->
        <div class="mt-3 p-3 rounded-xl bg-slate-900/90 border border-slate-800 space-y-1.5 text-xs">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1 flex items-center">
                <i class="fa-solid fa-shield-halved text-indigo-400 mr-1.5"></i> Strict Password Requirements:
            </div>
            <div id="rule-length" class="flex items-center text-slate-400 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-500 mr-2 w-3.5 text-center"></i>
                <span>At least <strong>10 characters</strong></span>
            </div>
            <div id="rule-upper" class="flex items-center text-slate-400 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-500 mr-2 w-3.5 text-center"></i>
                <span>At least <strong>1 uppercase letter</strong> (A-Z)</span>
            </div>
            <div id="rule-special" class="flex items-center text-slate-400 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-500 mr-2 w-3.5 text-center"></i>
                <span>At least <strong>1 special character</strong> (@$!%*?&#)</span>
            </div>
            <div id="rule-number" class="flex items-center text-slate-400 transition-colors">
                <i class="fa-solid fa-circle-xmark text-slate-500 mr-2 w-3.5 text-center"></i>
                <span>At least <strong>1 number</strong> (0-9)</span>
            </div>
        </div>
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
            Confirm Password
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-lock-check text-sm"></i>
            </div>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   required 
                   placeholder="••••••••••••"
                   class="w-full pl-10 pr-10 py-2.5 bg-slate-900/60 border border-slate-700 rounded-xl text-white placeholder-slate-500 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            <button type="button" 
                    onclick="togglePasswordVisibility('password_confirmation', this)" 
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200">
                <i class="fa-regular fa-eye text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            class="w-full mt-2 py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition duration-150 transform active:scale-[0.98] flex items-center justify-center space-x-2">
        <span>Create Account</span>
        <i class="fa-solid fa-user-plus text-xs"></i>
    </button>
</form>

<!-- Sign In Link -->
<div class="mt-6 pt-5 border-t border-white/10 text-center">
    <p class="text-xs text-slate-300">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition ml-1">
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
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function checkPasswordRequirements(value) {
        // 1. Length >= 10
        updateRuleUI('rule-length', value.length >= 10);

        // 2. Uppercase letter
        updateRuleUI('rule-upper', /[A-Z]/.test(value));

        // 3. Special character
        updateRuleUI('rule-special', /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]/.test(value));

        // 4. Number
        updateRuleUI('rule-number', /[0-9]/.test(value));
    }

    function updateRuleUI(elementId, isValid) {
        const el = document.getElementById(elementId);
        if (!el) return;
        const icon = el.querySelector('i');
        
        if (isValid) {
            el.className = 'flex items-center text-emerald-400 transition-colors';
            icon.className = 'fa-solid fa-circle-check text-emerald-400 mr-2 w-3.5 text-center';
        } else {
            el.className = 'flex items-center text-slate-400 transition-colors';
            icon.className = 'fa-solid fa-circle-xmark text-slate-500 mr-2 w-3.5 text-center';
        }
    }
</script>
@endsection

