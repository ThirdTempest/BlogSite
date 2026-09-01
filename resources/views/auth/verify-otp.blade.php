@extends('layouts.auth')

@section('title', 'Verify OTP')

@section('content')
<!-- Header Icon -->
<div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-200/60 flex items-center justify-center mx-auto mb-4 text-slate-700 text-lg">
    <i class="fa-solid fa-envelope-circle-check text-slate-800"></i>
</div>

<div class="text-center mb-6">
    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Verify Your Email</h2>
    <p class="text-xs text-slate-500 mt-1">
        We sent a 6-digit verification code to:
    </p>
    <div class="inline-block mt-2 px-3 py-1 bg-slate-100 border border-slate-200 rounded-lg text-xs font-bold text-slate-800">
        {{ $user->email }}
    </div>
</div>

<form action="{{ route('otp.submit') }}" method="POST" id="otpForm" class="space-y-4">
    @csrf

    <!-- Hidden Unified OTP Input -->
    <input type="hidden" name="otp" id="fullOtpInput">

    <!-- 6-Box OTP Input -->
    <div>
        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 text-center mb-2.5">
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
                       class="otp-digit w-11 h-12 sm:w-12 sm:h-14 text-center text-xl font-bold bg-slate-100/90 border @error('otp') border-rose-400 @else border-slate-200/80 @enderror rounded-xl text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-slate-900/15 focus:bg-white focus:border-slate-300 transition">
            @endfor
        </div>
        @error('otp')
            <p class="mt-2 text-xs text-rose-500 text-center flex items-center justify-center">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Countdown Timer & Status -->
    <div class="text-center text-xs text-slate-500 flex items-center justify-center space-x-1.5">
        <i class="fa-regular fa-clock text-slate-400"></i>
        <span>Code expires in:</span>
        <span id="countdownTimer" class="font-mono font-bold text-slate-800">10:00</span>
    </div>

    <!-- Submit Button -->
    <button type="submit" 
            id="verifyBtn" 
            class="w-full py-3 px-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.99] text-white font-semibold rounded-xl text-sm shadow-md shadow-slate-900/15 transition duration-150 flex items-center justify-center space-x-2 mt-2">
        <span>Verify & Enter Dashboard</span>
    </button>
</form>

<!-- Resend OTP Form -->
<div class="mt-5 pt-4 border-t border-slate-200/80 flex items-center justify-between text-xs">
    <span class="text-slate-500">Didn't receive code?</span>
    <form action="{{ route('otp.resend') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-slate-900 hover:text-indigo-600 font-semibold transition flex items-center space-x-1">
            <i class="fa-solid fa-rotate-right text-[11px] mr-1"></i>
            <span>Resend Code</span>
        </button>
    </form>
</div>

<!-- Sign Out Option -->
<div class="mt-3 text-center">
    <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-xs text-slate-500 hover:text-rose-600 transition">
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
            timerEl.className = 'font-mono font-bold text-rose-500';
            return;
        }
        timeLeft--;
        const mins = Math.floor(timeLeft / 60);
        const secs = timeLeft % 60;
        timerEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }, 1000);
</script>
@endsection
