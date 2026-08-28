@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Welcome Card -->
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-indigo-800 to-violet-900 rounded-3xl p-8 sm:p-10 text-white shadow-xl shadow-indigo-950/20 border border-indigo-700/40 text-center sm:text-left">
        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6">
            <div class="space-y-3">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-semibold text-indigo-200 border border-white/15">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Authenticated & 2FA Verified</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                    Welcome, {{ $user->name }}!
                </h1>
                <p class="text-indigo-200/90 text-sm max-w-xl leading-relaxed">
                    Welcome to <strong>BlogSite System</strong> — a site built with high security standards. Your session is active and protected.
                </p>
                <div class="pt-2 flex items-center space-x-2">
                    @if($user->isAdmin())
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-purple-500/30 text-purple-200 border border-purple-400/30">
                            <i class="fa-solid fa-shield-halved mr-1.5"></i> Super Administrator
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30">
                            <i class="fa-solid fa-user mr-1.5"></i> Member
                        </span>
                    @endif
                </div>
            </div>

            <!-- Avatar -->
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-white/10 text-white font-extrabold text-3xl sm:text-4xl flex items-center justify-center border border-white/20 shadow-inner backdrop-blur-md">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        </div>

        <!-- Decorative background glow -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Simple Account Info Card -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs">
        <h2 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center">
            <i class="fa-solid fa-id-card text-indigo-600 mr-2"></i> Account Overview
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-slate-500 block mb-1">Email Address</span>
                <span class="font-semibold text-slate-800 text-sm break-all">{{ $user->email }}</span>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-slate-500 block mb-1">Security Status</span>
                <span class="font-semibold text-emerald-700 text-sm flex items-center">
                    <i class="fa-solid fa-circle-check text-emerald-500 mr-1.5"></i> OTP Verified
                </span>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-slate-500 block mb-1">Member Since</span>
                <span class="font-semibold text-slate-800 text-sm">
                    {{ $user->created_at ? $user->created_at->format('M d, Y') : 'Today' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
