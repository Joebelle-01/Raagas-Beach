@extends('layouts.public')

@section('title', 'Our Cottages | Raagas Beach Resort')

@section('content')
<!-- Header -->
<div class="bg-sea-950 py-32 px-10 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <img src="{{ asset('assets/images/resort/hero.jpg') }}" alt="Header Background" class="w-full h-full object-cover">
    </div>
    <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full bg-sea-300/10 blur-3xl"></div>
    <div class="absolute -left-20 -bottom-20 w-96 h-96 rounded-full bg-sea-300/10 blur-3xl"></div>
    <div class="max-w-7xl mx-auto text-center space-y-6 relative z-10 animate-fade-in-up">
        <h1 class="text-5xl md:text-7xl font-serif text-white">Cottages</h1>
        <p class="text-white/60 max-w-2xl mx-auto text-lg">Explore our curated collection of beachfront and garden retreats, each designed for ultimate comfort and tranquility.</p>
    </div>
</div>

<!-- Cottages Grid -->
<div class="py-24 px-10 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        @forelse($cottages as $cottage)
            <div class="group glass-card overflow-hidden flex flex-col animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="h-80 overflow-hidden relative">
                    @if($cottage->images->count() > 0)
                        <img src="{{ Storage::url($cottage->images->first()->image_path) }}" alt="{{ $cottage->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-900 to-sea-950 flex flex-col items-center justify-center relative p-8 text-center overflow-hidden">
                            <div class="absolute inset-0 opacity-5">
                                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <pattern id="grid-index-{{ $cottage->id }}" width="20" height="20" patternUnits="userSpaceOnUse">
                                            <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="1"/>
                                        </pattern>
                                    </defs>
                                    <rect width="100%" height="100%" fill="url(#grid-index-{{ $cottage->id }})" />
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
                    
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur px-4 py-2 rounded-full text-[10px] font-black text-sea-900 uppercase tracking-[0.2em] shadow-sm">
                        Available Now
                    </div>
                </div>
                
                <div class="p-10 space-y-6 flex-grow flex flex-col">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-bold text-slate-800">{{ $cottage->name }}</h3>
                        <div class="text-right">
                            <span class="text-sea-900 font-black text-2xl">₱{{ number_format($cottage->price, 0) }}</span>
                            <span class="text-slate-400 text-xs block font-bold uppercase tracking-tighter">per night</span>
                        </div>
                    </div>
                    
                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 flex-grow">
                        {{ $cottage->description }}
                    </p>
                    
                    <div class="flex items-center gap-8 pt-6 border-t border-sand-100 mt-auto">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-sand-100 flex items-center justify-center text-sea-300">👤</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Capacity <br><span class="text-slate-700 text-xs">{{ $cottage->capacity }} Guests</span></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-sand-100 flex items-center justify-center text-sea-300">✨</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Feature <br><span class="text-slate-700 text-xs">Premium Wifi</span></div>
                        </div>
                    </div>
                    
                    <a href="{{ route('cottages.show', $cottage->slug) }}" class="btn-primary-resort w-full block text-center mt-4">
                        View Experience
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center space-y-6">
                <div class="text-8xl">🏝️</div>
                <h2 class="text-3xl font-serif text-slate-900">Our Sanctuary is Currently Full</h2>
                <p class="text-slate-500 max-w-md mx-auto">We are currently updating our cottage availability. Please contact our concierge for immediate assistance.</p>
                <a href="{{ route('home') }}" class="btn-primary-resort inline-block">Return Home</a>
            </div>
        @endforelse
    </div>
</div>

<!-- Benefits -->
<div class="bg-white py-32 px-10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
        <div class="space-y-4 p-8">
            <div class="text-4xl">🛡️</div>
            <h4 class="text-xl font-bold">Secure Booking</h4>
            <p class="text-slate-500">Your data and payments are always protected with our secure system.</p>
        </div>
        <div class="space-y-4 p-8">
            <div class="text-4xl">🔄</div>
            <h4 class="text-xl font-bold">Flexible Check-in</h4>
            <p class="text-slate-500">Contact us for early arrivals or late departures to suit your travel schedule.</p>
        </div>
        <div class="space-y-4 p-8">
            <div class="text-4xl">🌟</div>
            <h4 class="text-xl font-bold">Best Rate Guarantee</h4>
            <p class="text-slate-500">Book directly with us to get the best possible rates and exclusive benefits.</p>
        </div>
    </div>
</div>
@endsection
