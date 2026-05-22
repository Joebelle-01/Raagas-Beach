<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-sand-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/login-bg.jpg') }}');">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
            
            <div class="relative z-10">
                <a href="/">
                    <div class="flex flex-col items-center mb-4">
                        <x-application-logo class="w-24 h-24 fill-current text-white drop-shadow-lg" />
                        <h1 class="text-white text-3xl font-bold mt-2 drop-shadow-md tracking-wider">RAAGAS BEACH</h1>
                    </div>
                </a>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-2 px-8 py-8 bg-white/90 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20">
                {{ $slot }}
            </div>
            
            <div class="relative z-10 mt-8 text-white/80 text-sm drop-shadow-md">
                &copy; {{ date('Y') }} Raagas Beach Resort. All rights reserved.
            </div>
        </div>
    </body>
</html>
