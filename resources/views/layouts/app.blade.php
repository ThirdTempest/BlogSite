<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Automata') }} - @yield('title', 'System')</title>

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
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased">
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Main Nav -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-200">
                            <i class="fa-solid fa-layer-group text-lg"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-violet-700 bg-clip-text text-transparent">
                            BlogSite
                        </span>
                    </a>

                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('dashboard') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <i class="fa-solid fa-gauge-high mr-1.5"></i> Dashboard
                        </a>

                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('users.index') }}" 
                               class="px-3.5 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <i class="fa-solid fa-users-gear mr-1.5"></i> User Management
                            </a>
                        @endif
                    </div>
                </div>

                <!-- User Profile & Actions -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3 pl-4 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-sm border border-indigo-200">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-sm font-semibold text-slate-800 leading-tight">{{ Auth::user()->name }}</div>
                            <div class="text-xs font-medium flex items-center space-x-1.5 mt-0.5">
                                @if(Auth::user()->isAdmin())
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700 uppercase tracking-wider">
                                        <i class="fa-solid fa-shield-halved text-[9px] mr-1"></i> Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wider">
                                        <i class="fa-solid fa-user text-[9px] mr-1"></i> User
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition text-sm font-medium flex items-center" 
                                title="Sign Out">
                            <i class="fa-solid fa-arrow-right-from-bracket text-base"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Body Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center shadow-xs">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg mr-3"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-4 flex items-center shadow-xs">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg mr-3"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl p-4 flex items-center shadow-xs">
                <i class="fa-solid fa-circle-info text-blue-500 text-lg mr-3"></i>
                <span class="text-sm font-medium">{{ session('info') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-4 shadow-xs">
                <div class="flex items-center mb-2 font-semibold text-sm">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 mr-2"></i>
                    Please correct the following errors:
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 space-y-2 sm:space-y-0">
            <div>
                &copy; {{ date('Y') }} <strong>BlogSite System</strong>. A Site with Good Security.
            </div>
            <div class="flex items-center space-x-3 text-slate-400">
                <span><i class="fa-solid fa-lock text-indigo-500 mr-1"></i> Strict Password Policy</span>
                <span>•</span>
                <span><i class="fa-solid fa-shield text-purple-500 mr-1"></i> 2FA Email OTP Protected</span>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>

