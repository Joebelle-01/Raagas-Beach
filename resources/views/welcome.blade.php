<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Raagas Beach Resort | Your Tropical Escape</title>
        
        <!-- SEO -->
        <meta name="description" content="Experience luxury and tranquility at Raagas Beach Resort. The ultimate tropical getaway with beachfront cottages and world-class amenities.">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .hero-parallax {
                background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.2)), url("{{ asset('assets/images/resort/hero.jpg') }}");
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
        </style>
    </head>
    <body class="antialiased">
        @if(session('success'))
            <div class="fixed top-24 right-10 z-[100] animate-bounce-subtle">
                <div class="bg-green-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="fixed top-24 right-10 z-[100] animate-bounce-subtle">
                <div class="bg-red-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        <!-- Navigation -->
        <nav class="fixed w-full z-50 transition-all duration-500 py-6 px-10 flex justify-between items-center bg-transparent" id="navbar">
            <div class="text-2xl font-bold text-white tracking-tighter flex items-center gap-2">
                <div class="bg-sea-300 w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-sea-300/30">
                    <span class="text-white">RB</span>
                </div>
                <span class="font-serif uppercase tracking-widest text-lg hidden sm:block">Raagas Beach</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-white/90 font-semibold text-sm uppercase tracking-widest">
                <a href="#home" class="hover:text-sea-300 transition-colors">Home</a>
                <a href="{{ route('cottages.index') }}" class="hover:text-sea-300 transition-colors">Cottages</a>
            </div>
            
            <div class="flex items-center gap-6">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-white font-bold hover:text-sea-300">DASHBOARD</a>
                @else
                    <a href="{{ route('login') }}" class="text-white font-bold hover:text-sea-300 text-sm uppercase tracking-widest transition-colors mr-2">LOG IN</a>
                    <a href="{{ route('cottages.index') }}" class="bg-white text-slate-900 px-8 py-3 rounded-full font-bold hover:bg-sea-300 hover:text-white transition-all shadow-xl">BOOK NOW</a>
                @endauth
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="hero-parallax h-screen flex items-center justify-center text-center text-white px-4 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="max-w-5xl space-y-8 relative z-10 animate-fade-in-up">
                <span class="section-subtitle text-sea-300">Welcome to Paradise</span>
                <h1 class="text-6xl md:text-8xl font-serif leading-none drop-shadow-2xl">Elevate Your <br><span class="text-sea-300">Beach Escape</span></h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-2xl mx-auto font-light leading-relaxed">
                    Unplug from the world and immerse yourself in the serene beauty of the coast. Luxury, comfort, and nature intertwined.
                </p>
                <div class="flex flex-wrap justify-center gap-6 pt-6">
                    <a href="{{ route('cottages.index') }}" class="btn-primary-resort">Discover Cottages</a>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
        </section>

        <!-- Featured Cottages -->
        <section class="py-32 px-10 bg-sand-50">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                    <div class="space-y-4">
                        <span class="section-subtitle">Accommodation</span>
                        <h2 class="section-title">Our Signature Cottages</h2>
                    </div>
                    <a href="{{ route('cottages.index') }}" class="text-sea-900 font-bold flex items-center gap-2 group">
                        VIEW ALL COTTAGES 
                        <span class="group-hover:translate-x-2 transition-transform">→</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @forelse($featuredCottages as $cottage)
                        @php
                            $img = $cottage->images->count() > 0 ? Storage::url($cottage->images->first()->image_path) : null;
                            
                            $viewName = 'Resort View';
                            if (str_contains(strtolower($cottage->name), 'ocean')) {
                                $viewName = 'Beach Front';
                            } elseif (str_contains(strtolower($cottage->name), 'garden')) {
                                $viewName = 'Garden View';
                            }
                        @endphp
                        <div class="group glass-card overflow-hidden flex flex-col">
                            <div class="h-80 overflow-hidden relative">
                                @if($img)
                                    <img src="{{ $img }}" alt="{{ $cottage->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-slate-900 to-sea-950 flex flex-col items-center justify-center relative p-8 text-center overflow-hidden">
                                        <div class="absolute inset-0 opacity-5">
                                            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <pattern id="grid-{{ $cottage->id }}" width="20" height="20" patternUnits="userSpaceOnUse">
                                                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="1"/>
                                                    </pattern>
                                                </defs>
                                                <rect width="100%" height="100%" fill="url(#grid-{{ $cottage->id }})" />
                                            </svg>
                                        </div>
                                        <div class="absolute w-40 h-40 rounded-full bg-sea-500/10 blur-2xl"></div>
                                        <div class="bg-white/5 backdrop-blur-md w-16 h-16 rounded-2xl flex items-center justify-center border border-white/10 shadow-xl mb-4 relative z-10">
                                            <span class="text-white text-xl font-bold tracking-wider font-serif">RB</span>
                                        </div>
                                        <span class="text-white/40 text-[10px] font-black uppercase tracking-[0.3em] relative z-10 mb-1">RAAGAS BEACH RESORT</span>
                                        <span class="text-sea-300 font-serif text-sm italic relative z-10">{{ $cottage->name }}</span>
                                    </div>
                                @endif
                                @if($loop->first)
                                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-full text-xs font-bold text-sea-900 uppercase tracking-widest shadow-sm">Popular Choice</div>
                                @elseif($loop->last)
                                    <div class="absolute top-6 left-6 bg-amber-500 px-4 py-2 rounded-full text-xs font-bold text-white uppercase tracking-widest shadow-sm">Exclusive</div>
                                @endif
                            </div>
                            <div class="p-10 space-y-6 flex-grow flex flex-col">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-2xl font-bold">{{ $cottage->name }}</h3>
                                    <div class="text-sea-900 font-bold text-xl">₱ {{ number_format($cottage->price, 0) }} <span class="text-slate-400 text-sm font-normal block text-right">/ night</span></div>
                                </div>
                                <p class="text-slate-500 line-clamp-2">{{ $cottage->description }}</p>
                                <div class="flex gap-6 pt-4 border-t border-slate-100 mt-auto">
                                    <div class="text-center">
                                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-tighter">Capacity</span>
                                        <span class="font-bold text-slate-700">{{ $cottage->capacity }} Persons</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-tighter">View</span>
                                        <span class="font-bold text-slate-700">{{ $viewName }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('cottages.show', $cottage->slug) }}" class="btn-primary-resort text-center mt-4 w-full block">
                                    Book Experience
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center space-y-6 bg-white/50 backdrop-blur rounded-[2.5rem] p-12 border border-slate-100 shadow-xl animate-fade-in-up">
                            <div class="text-6xl animate-bounce-subtle">🏝️</div>
                            <h3 class="text-3xl font-serif text-slate-800">Your Private Beach Escape</h3>
                            <p class="text-slate-500 max-w-md mx-auto">We are currently updating our sanctuary availability. Please view our full cottages catalog or contact our concierge for booking inquiries.</p>
                            <a href="{{ route('cottages.index') }}" class="btn-primary-resort inline-block">Explore Cottages</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Newsletter / CTA -->
        <section class="py-24 px-10">
            <div class="max-w-7xl mx-auto bg-sea-900 rounded-[3rem] p-12 md:p-24 text-center text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-sea-950 via-sea-900 to-slate-900 opacity-95"></div>
                <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-sea-500/10 blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-sea-500/10 blur-3xl"></div>
                <div class="relative z-10 space-y-8">
                    <h2 class="text-4xl md:text-6xl font-serif">Ready to book your dream <br>vacation?</h2>
                    <p class="text-white/60 max-w-xl mx-auto text-lg">Join 10,000+ happy travelers who chose Raagas Beach Resort for their tropical escape.</p>
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="{{ route('cottages.index') }}" class="btn-primary-resort px-12 bg-white text-sea-900 hover:bg-sand-50">Book Your Stay Now</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white pt-24 pb-12 px-10 border-t border-slate-100">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="space-y-6">
                    <div class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                        <div class="bg-sea-300 w-8 h-8 rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white text-sm">RB</span>
                        </div>
                        <span class="font-serif text-lg">RAAGAS BEACH</span>
                    </div>
                    <p class="text-slate-500 text-sm">Experience the ultimate tropical luxury. Your comfort is our priority.</p>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-6 uppercase tracking-widest text-xs">Quick Links</h5>
                    <ul class="space-y-4 text-slate-500 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-sea-300 transition-colors">Home</a></li>
                        <li><a href="{{ route('cottages.index') }}" class="hover:text-sea-300 transition-colors">Cottages</a></li>
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
                        <input type="email" placeholder="Email address" class="bg-slate-50 border border-slate-100 rounded-full px-6 py-3 text-sm flex-grow focus:outline-none focus:ring-2 focus:ring-sea-300/20">
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
            <div class="max-w-7xl mx-auto pt-8 border-t border-slate-50 flex flex-col md:row justify-between items-center gap-4 text-slate-400 text-xs">
                <p>© 2024 Raagas Beach Resort. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-sea-300">Facebook</a>
                    <a href="#" class="hover:text-sea-300">Instagram</a>
                    <a href="#" class="hover:text-sea-300">Twitter</a>
                </div>
            </div>
        </footer>

        <script>
            window.addEventListener('scroll', function() {
                const nav = document.getElementById('navbar');
                if (window.scrollY > 100) {
                    nav.classList.add('bg-white/80', 'backdrop-blur-lg', 'shadow-xl', 'py-4');
                    nav.classList.remove('bg-transparent', 'py-6');
                    nav.querySelector('.text-white')?.classList.replace('text-white', 'text-slate-900');
                    const links = nav.querySelectorAll('.text-white\\/90');
                    links.forEach(l => l.classList.replace('text-white/90', 'text-slate-600'));
                    

                    
                    const bookBtn = nav.querySelector('a[href$="cottages"]');
                    if(bookBtn && bookBtn.classList.contains('bg-white')) {
                        bookBtn.classList.replace('bg-white', 'bg-sea-300');
                        bookBtn.classList.replace('text-slate-900', 'text-white');
                    }
                } else {
                    nav.classList.remove('bg-white/80', 'backdrop-blur-lg', 'shadow-xl', 'py-4');
                    nav.classList.add('bg-transparent', 'py-6');
                    
                    const logo = nav.querySelector('.text-slate-900');
                    if(logo) logo.classList.replace('text-slate-900', 'text-white');
                    
                    const links = nav.querySelectorAll('.text-slate-600');
                    links.forEach(l => l.classList.replace('text-slate-600', 'text-white/90'));
                    

                    
                    const bookBtn = nav.querySelector('a[href$="cottages"]');
                    if(bookBtn && bookBtn.classList.contains('bg-sea-300')) {
                        bookBtn.classList.replace('bg-sea-300', 'bg-white');
                        bookBtn.classList.replace('text-white', 'text-slate-900');
                    }
                }
            });
        </script>
    </body>
</html>
