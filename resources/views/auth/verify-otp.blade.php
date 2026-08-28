@extends('layouts.auth')

@section('title', 'Verify OTP')

@section('content')
<div class="text-center mb-6">
    <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-2xl border border-indigo-500/30">
        <i class="fa-solid fa-envelope-circle-check"></i>
    </div>
    <h2 class="text-xl font-bold text-white">Verify Your Email</h2>
    <p class="text-xs text-slate-300 mt-1">
        We sent a 6-digit verification code to:
    </p>
    <div class="inline-block mt-1 px-3 py-1 bg-indigo-950/80 border border-indigo-800 rounded-lg text-xs font-semibold text-indigo-300">
        {{ $user->email }}
    </div>
</div>

<form action="{{ route('otp.submit') }}" method="POST" id="otpForm" class="space-y-5">
    @csrf

    <!-- Hidden Unified OTP Input -->
    <input type="hidden" name="otp" id="fullOtpInput">

    <!-- 6-Box OTP Input -->
    <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 text-center mb-2.5">
            Enter 6-Digit Code
        </label>
        <div class="flex justify-center gap-2 sm:gap-2.5">
            @for ($i = 0; $i < 6; $i++)
                <input type="text" 
                       id="digit-{{ $i }}" 
                       maxlength="1" 
                       inputmode="numeric" 
                       pattern="[0-9]*" 
                       autocomplete="one-time-code"
                       class="otp-digit w-11 h-12 sm:w-12 sm:h-14 text-center text-xl font-bold bg-slate-900/70 border @error('otp') border-rose-500 @else border-slate-700 @enderror rounded-xl text-white focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            @endfor
        </div>
        @error('otp')
            <p class="mt-2 text-xs text-rose-400 text-center flex items-center justify-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Countdown Timer & Status -->
    <div class="text-center text-xs text-slate-400 flex items-center justify-center space-x-1.5">
        <i class="fa-regular fa-clock text-indigo-400"></i>
        <span>Code expires in:</span>
        <span id="countdownTimer" class="font-mono font-bold text-indigo-300">10:00</span>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            id="verifyBtn" 
            class="w-full py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition duration-150 transform active:scale-[0.98] flex items-center justify-center space-x-2">
        <span>Verify & Enter Dashboard</span>
        <i class="fa-solid fa-arrow-right text-xs"></i>
    </button>
</form>

<!-- Resend OTP Form -->
<div class="mt-5 pt-4 border-t border-white/10 flex items-center justify-between text-xs">
    <span class="text-slate-400">Didn't receive code?</span>
    <form action="{{ route('otp.resend') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-indigo-400 hover:text-indigo-300 font-semibold transition flex items-center space-x-1">
            <i class="fa-solid fa-rotate-right text-[11px] mr-1"></i>
            <span>Resend Code</span>
        </button>
    </form>
</div>

<!-- Sign Out Option -->
<div class="mt-3 text-center">
    <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-xs text-slate-400 hover:text-rose-400 transition">
            <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Sign out & try another account
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const inputs = document.querySelectorAll('.otp-digit');
    const fullOtpInput = document.getElementById('fullOtpInput');
    const form = document.getElementById('otpForm');

    // Auto-focus first input
    if (inputs.length > 0) {
        inputs[0].focus();
    }

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            input.value = input.value.replace(/[^0-9]/g, '');

            if (input.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            syncFullOtp();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
            if (/^\d+$/.test(pasteData)) {
                const digits = pasteData.slice(0, 6).split('');
                digits.forEach((digit, i) => {
                    if (inputs[i]) {
                        inputs[i].value = digit;
                    }
                });
                syncFullOtp();
                if (digits.length >= 6) {
                    inputs[5].focus();
                } else {
                    inputs[digits.length].focus();
                }
            }
        });
    });

    function syncFullOtp() {
        let code = '';
        inputs.forEach(input => code += input.value);
        fullOtpInput.value = code;
    }

    form.addEventListener('submit', (e) => {
        syncFullOtp();
    });

    // 10-Minute Countdown Timer
    let timeLeft = 600;
    const timerEl = document.getElementById('countdownTimer');
    const timerInterval = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            timerEl.textContent = 'Expired';
            timerEl.className = 'font-mono font-bold text-rose-400';
            return;
        }
        timeLeft--;
        const mins = Math.floor(timeLeft / 60);
        const secs = timeLeft % 60;
        timerEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }, 1000);
</script>
@endsection

