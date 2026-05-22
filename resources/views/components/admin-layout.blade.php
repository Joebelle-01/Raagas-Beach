<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Raagas Admin') }} - Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

        <!-- GLightbox -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Flatpickr -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        <style>
            :root {
                --primary: #1e293b;
                --accent: #f59e0b;
                --sidebar-bg: #0f172a;
            }
            body {
                font-family: 'Outfit', sans-serif;
            }
            .font-serif {
                font-family: 'Playfair Display', serif;
            }
            .sidebar-link.active {
                background-color: rgba(255, 255, 255, 0.1);
                border-left: 4px solid var(--accent);
                color: white;
            }

            @media print {
                .print\:hidden {
                    display: none !important;
                }
                body {
                    background-color: white !important;
                    font-size: 12pt;
                }
                main {
                    padding: 0 !important;
                    margin: 0 !important;
                }
                .no-print {
                    display: none !important;
                }
                .print-only {
                    display: block !important;
                }
                .shadow-2xl, .shadow-lg, .shadow-sm {
                    shadow: none !important;
                    box-shadow: none !important;
                }
                .border {
                    border: 1px solid #e2e8f0 !important;
                }
            }
        </style>
    </head>
    <body class="h-full overflow-hidden flex">
        
        <!-- Sidebar -->
        <aside class="hidden md:flex flex-col w-72 bg-slate-900 text-slate-300 print:hidden">
            <div class="p-8">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('staff.dashboard') }}" class="flex items-center gap-3">
                    <span class="text-2xl font-serif italic text-amber-500 font-bold">R</span>
                    <span class="text-xl font-bold tracking-tight text-white uppercase">Raagas <span class="text-amber-500 font-normal">Beach</span></span>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-2 overflow-y-auto pb-8">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-4">Core Management</p>
                
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Dashboard Overview</span>
                </a>
                @else
                <a href="{{ route('staff.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Staff Dashboard</span>
                </a>
                @endif

                <a href="{{ route('admin.bookings.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium">Reservations</span>
                </a>

                <a href="{{ route('admin.cottages.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('admin.cottages.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="font-medium">Manage Cottages</span>
                </a>

                <div class="pt-8">
                    <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest mb-4">Operations</p>
                    
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.reports') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span class="font-medium">Sales & Reports</span>
                    </a>

                    <a href="{{ route('admin.logs') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">Audit Logs</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/5 transition-all {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="font-medium">Staff Management</span>
                    </a>
                    @endif
                </div>
            </nav>

            <div class="p-6 border-t border-white/10 bg-black/20">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 uppercase font-medium">{{ auth()->user()->role->name }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-xs text-slate-400 hover:text-white transition-colors">Sign Out &larr;</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0 print:hidden">
                <div>
                    @isset($header)
                        {{ $header }}
                    @else
                        <h1 class="text-xl font-bold text-slate-800">Management Dashboard</h1>
                    @endisset
                </div>
                
                <div class="flex items-center gap-6">
                    <button class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>
                    <div class="h-8 w-px bg-slate-200"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800">{{ now()->format('l, M d') }}</p>
                            <p class="text-xs text-slate-500">Raagas Beach Resort</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
        <script>
            const lightbox = GLightbox({
                selector: '.glightbox'
            });

            // Initialize Flatpickr for elements with the class
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr(".flatpickr", {
                    dateFormat: "Y-m-d",
                });
            });
        </script>
        @stack('scripts')
    </body>
</html>
