<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Automata') }} - @yield('title', 'Authentication')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-slate-100 min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 antialiased relative overflow-x-hidden">
    <!-- Ambient Background Lighting -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md my-auto relative z-10">
        <!-- Brand Header -->
        <div class="text-center mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center space-x-3 mb-2">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-500/30 ring-1 ring-white/20">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-white">BlogSite System</h1>
            <p class="text-xs text-indigo-200/70 mt-1">A Site with Good Security</p>
        </div>

        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-4 bg-emerald-950/80 border border-emerald-500/30 text-emerald-300 rounded-xl p-3.5 flex items-center text-sm backdrop-blur-md">
                <i class="fa-solid fa-circle-check text-emerald-400 mr-2.5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('status'))
            <div class="mb-4 bg-indigo-950/80 border border-indigo-500/30 text-indigo-200 rounded-xl p-3.5 flex items-center text-sm backdrop-blur-md">
                <i class="fa-solid fa-circle-info text-indigo-400 mr-2.5"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-rose-950/80 border border-rose-500/30 text-rose-300 rounded-xl p-3.5 flex items-center text-sm backdrop-blur-md">
                <i class="fa-solid fa-circle-exclamation text-rose-400 mr-2.5"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Card Container -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl p-6 sm:p-8 shadow-2xl shadow-black/40">
            @yield('content')
        </div>

        <!-- Bottom Footer -->
        <div class="text-center mt-6 text-xs text-slate-400">
            &copy; {{ date('Y') }} BlogSite System. All rights reserved.
        </div>
    </div>

    @yield('scripts')
</body>
</html>

