<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BlogSite System') }} - @yield('title', 'Authentication')</title>

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
                            50: '#f0fdf4',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-image: url("{{ asset('background.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 antialiased relative selection:bg-slate-900 selection:text-white">
    <!-- Top-Left Brand Logo & Title -->
    <div class="absolute top-5 left-5 sm:top-7 sm:left-8 flex items-center space-x-2.5 z-20">
        <a href="{{ url('/') }}" class="flex items-center space-x-2.5 group">
            <div class="w-8 h-8 rounded-xl overflow-hidden shadow-xs border border-white/60 bg-white/70 backdrop-blur-md flex items-center justify-center p-1 group-hover:scale-105 transition">
                <img src="{{ asset('bloglogo.png') }}" alt="BlogSite Logo" class="w-full h-full object-contain">
            </div>
            <span class="font-extrabold text-slate-900 text-base tracking-tight drop-shadow-xs">BlogSite</span>
        </a>
    </div>

    <!-- Centered Card Container -->
    <div class="w-full max-w-[430px] my-auto relative z-10 pt-12 sm:pt-0">
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-4 bg-emerald-50/90 border border-emerald-300 text-emerald-800 rounded-2xl p-3.5 flex items-center text-xs backdrop-blur-md shadow-xs">
                <i class="fa-solid fa-circle-check text-emerald-600 mr-2.5 text-sm"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('status'))
            <div class="mb-4 bg-sky-50/90 border border-sky-300 text-sky-800 rounded-2xl p-3.5 flex items-center text-xs backdrop-blur-md shadow-xs">
                <i class="fa-solid fa-circle-info text-sky-600 mr-2.5 text-sm"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-rose-50/90 border border-rose-300 text-rose-800 rounded-2xl p-3.5 flex items-center text-xs backdrop-blur-md shadow-xs">
                <i class="fa-solid fa-circle-exclamation text-rose-600 mr-2.5 text-sm"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Card Container -->
        <div class="bg-white/80 backdrop-blur-2xl border border-white/90 rounded-[32px] p-7 sm:p-9 shadow-2xl shadow-sky-950/10">
            @yield('content')
        </div>

        <!-- Bottom Footer -->
        <div class="text-center mt-5 text-xs text-slate-500 drop-shadow-xs">
            &copy; {{ date('Y') }} BlogSite System. All rights reserved.
        </div>
    </div>

    @yield('scripts')
</body>
</html>
