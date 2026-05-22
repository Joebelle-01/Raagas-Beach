<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Raagas Beach Resort')</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
        
        <!-- App styles & Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Flatpickr -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    </head>
    <body class="antialiased bg-sand-50 text-slate-900 min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="w-full z-50 py-4 px-10 flex justify-between items-center bg-white shadow-sm sticky top-0 border-b border-sand-100" id="navbar">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-slate-900 tracking-tighter flex items-center gap-3">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Raagas Beach" class="w-10 h-10 rounded-full border border-slate-100 shadow-md object-cover">
                <span class="font-serif text-lg tracking-widest hidden sm:block">RAAGAS BEACH</span>
            </a>
            
            <div class="hidden md:flex gap-8 text-slate-600 font-medium tracking-wide">
                <a href="{{ route('home') }}" class="hover:text-sea-300 transition-colors {{ request()->routeIs('home') ? 'text-sea-300' : '' }}">Home</a>
                <a href="{{ route('home') }}#about" class="hover:text-sea-300 transition-colors">About</a>
                <a href="{{ route('home') }}#features" class="hover:text-sea-300 transition-colors">Features</a>
                <a href="{{ route('cottages.index') }}" class="hover:text-sea-300 transition-colors {{ request()->routeIs('cottages.*') ? 'text-sea-300' : '' }}">Cottages</a>
                <a href="{{ route('home') }}#contact" class="hover:text-sea-300 transition-colors">Contact</a>
            </div>
            
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-slate-600 font-bold hover:text-sea-300 text-sm">DASHBOARD</a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 font-bold hover:text-sea-300 text-xs uppercase tracking-widest transition-colors mr-2">LOG IN</a>
                    <a href="{{ route('cottages.index') }}" class="btn-primary-resort text-sm px-6 py-2">BOOK NOW</a>
                @endauth
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-10 mt-6 w-full animate-fade-in-up">
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-sm">
                    <span class="text-2xl">✨</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-10 mt-6 w-full animate-fade-in-up">
                <div class="bg-rose-50 border border-rose-100 text-rose-800 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-sm">
                    <span class="text-2xl">⚠️</span>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <main class="flex-grow">
            @yield('content')
        </main>

        <footer class="bg-white pt-24 pb-12 px-10 border-t border-sand-100">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-12 mb-20">
                <div class="space-y-6">
                    <div class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Raagas Beach Logo" class="w-10 h-10 rounded-full border border-slate-100 shadow-md object-cover">
                        <span class="font-serif text-lg uppercase tracking-widest">RAAGAS BEACH</span>
                    </div>
                    <p class="text-slate-500 text-sm">Experience the ultimate tropical luxury. Your comfort is our priority.</p>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-6 uppercase tracking-widest text-xs">Quick Links</h5>
                    <ul class="space-y-4 text-slate-500 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-sea-300 transition-colors">Home</a></li>
                        <li><a href="{{ route('home') }}#about" class="hover:text-sea-300 transition-colors">About the Project</a></li>
                        <li><a href="{{ route('home') }}#features" class="hover:text-sea-300 transition-colors">Features</a></li>
                        <li><a href="{{ route('cottages.index') }}" class="hover:text-sea-300 transition-colors">Cottages</a></li>
                        <li><a href="{{ route('home') }}#contact" class="hover:text-sea-300 transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-6 uppercase tracking-widest text-xs">Support</h5>
                    <ul class="space-y-4 text-slate-500 text-sm">
                        <li><a href="mailto:info@raagasbeach.com" class="hover:text-sea-300 transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-sea-300 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-sea-300 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-6 uppercase tracking-widest text-xs">Newsletter</h5>
                    <p class="text-slate-500 text-sm mb-6">Get exclusive offers and news.</p>
                    <div class="flex gap-2">
                        <input type="email" placeholder="Email address" class="bg-sand-50 border border-sand-100 rounded-full px-6 py-3 text-sm flex-grow focus:outline-none focus:ring-2 focus:ring-sea-300/20">
                        <button class="bg-sea-300 text-white p-3 rounded-full hover:bg-sea-300 shadow-lg shadow-sea-300/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-6 uppercase tracking-widest text-xs">Internal</h5>
                    <ul class="space-y-4 text-slate-500 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-sea-300 transition-colors">Staff Portal</a></li>
                    </ul>
                </div>
            </div>
            <div class="max-w-7xl mx-auto pt-8 border-t border-sand-100 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-xs">
                <p>© {{ date('Y') }} Raagas Beach Resort. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-sea-300">Facebook</a>
                    <a href="#" class="hover:text-sea-300">Instagram</a>
                    <a href="#" class="hover:text-sea-300">Twitter</a>
                </div>
            </div>
        </footer>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr(".flatpickr", {
                    dateFormat: "Y-m-d",
                });
            });
        </script>
    </body>
</html>
