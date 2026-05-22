@extends('layouts.public')

@section('title', $cottage->name . ' | Raagas Beach Resort')

@section('content')
<div class="max-w-7xl mx-auto px-10 py-16">
    <!-- Breadcrumbs -->
    <nav class="flex text-slate-400 text-xs font-bold uppercase tracking-widest mb-8 gap-2">
        <a href="{{ route('home') }}" class="hover:text-sea-500">Home</a>
        <span>/</span>
        <a href="{{ route('cottages.index') }}" class="hover:text-sea-500">Cottages</a>
        <span>/</span>
        <span class="text-slate-900">{{ $cottage->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
        <!-- Left: Cottage Details (8 columns) -->
        <div class="lg:col-span-8 space-y-12 animate-fade-in-up">
            <!-- Gallery Grid -->
            <!-- Dynamic Gallery -->
            @php
                $cottageImages = $cottage->images;
                $imageCount = $cottageImages->count();
            @endphp

            @if($imageCount === 0)
                <!-- No uploaded images: Show a stunning luxury resort banner card -->
                <div class="w-full h-[400px] bg-gradient-to-br from-slate-900 via-sea-950 to-slate-950 rounded-3xl flex flex-col items-center justify-center relative p-12 text-center overflow-hidden shadow-2xl">
                    <div class="absolute inset-0 opacity-5">
                        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="grid-show" width="30" height="30" patternUnits="userSpaceOnUse">
                                    <path d="M 30 0 L 0 0 0 30" fill="none" stroke="white" stroke-width="1"/>
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#grid-show)" />
                        </svg>
                    </div>
                    <div class="absolute w-96 h-96 rounded-full bg-sea-500/10 blur-3xl"></div>
                    
                    <!-- Stylized emblem -->
                    <div class="bg-white/5 backdrop-blur-md w-24 h-24 rounded-[2rem] flex items-center justify-center border border-white/10 shadow-2xl mb-6 relative z-10">
                        <span class="text-white text-3xl font-bold tracking-wider font-serif">RB</span>
                    </div>
                    <span class="text-white/40 text-xs font-black uppercase tracking-[0.4em] relative z-10 mb-2">RAAGAS BEACH RESORT</span>
                    <h2 class="text-sea-300 font-serif text-3xl md:text-4xl italic relative z-10 font-bold mb-4">{{ $cottage->name }}</h2>
                    <p class="text-white/60 max-w-md mx-auto text-sm font-light relative z-10">A secluded private sanctuary awaiting your arrival.</p>
                </div>
            @elseif($imageCount === 1)
                <!-- 1 Image: Large, beautiful full-width banner -->
                <div class="w-full h-[500px] rounded-3xl overflow-hidden shadow-2xl relative group">
                    <img src="{{ Storage::url($cottageImages->first()->image_path) }}" alt="{{ $cottage->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                </div>
            @elseif($imageCount === 2)
                <!-- 2 Images: Side-by-side duo -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-[400px]">
                    @foreach($cottageImages as $img)
                        <div class="rounded-3xl overflow-hidden shadow-xl relative group">
                            <img src="{{ Storage::url($img->image_path) }}" alt="{{ $cottage->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                    @endforeach
                </div>
            @else
                <!-- 3+ Images: Standard beautiful grid -->
                <div class="grid grid-cols-4 grid-rows-2 gap-4 h-[600px]">
                    <div class="col-span-3 row-span-2 rounded-3xl overflow-hidden shadow-2xl relative group">
                        <img src="{{ Storage::url($cottageImages->get(0)->image_path) }}" alt="{{ $cottage->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-lg relative group">
                        <img src="{{ Storage::url($cottageImages->get(1)->image_path) }}" alt="{{ $cottage->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-lg relative group">
                        <img src="{{ Storage::url($cottageImages->get(2)->image_path) }}" alt="{{ $cottage->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                </div>
            @endif

            <div class="space-y-8">
                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <div>
                        <span class="section-subtitle">Luxury Stay</span>
                        <h1 class="text-5xl font-serif font-bold text-slate-900">{{ $cottage->name }}</h1>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-50 text-emerald-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest border border-emerald-100">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        Available for Booking
                    </div>
                </div>

                <!-- Features Icon Bar -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-8 border-y border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sea-50 flex items-center justify-center text-xl">👥</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Capacity <br><span class="text-slate-700 text-xs">{{ $cottage->capacity }} Guests</span></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sea-50 flex items-center justify-center text-xl">📶</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Connectivity <br><span class="text-slate-700 text-xs">High-Speed Wifi</span></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sea-50 flex items-center justify-center text-xl">❄️</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Comfort <br><span class="text-slate-700 text-xs">Air Conditioned</span></div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sea-50 flex items-center justify-center text-xl">🌅</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">View <br><span class="text-slate-700 text-xs">Premium Vistas</span></div>
                    </div>
                </div>

                <!-- Description -->
                <div class="prose prose-slate max-w-none">
                    <h3 class="text-2xl font-serif font-bold mb-6">Experience the Retreat</h3>
                    <p class="text-slate-600 leading-relaxed text-lg">
                        {{ $cottage->description }}
                    </p>
                    <p class="text-slate-600 leading-relaxed text-lg mt-4">
                        Every detail in the {{ $cottage->name }} has been meticulously crafted to provide you with a seamless blend of luxury and nature. From the hand-picked furnishings to the premium linens, your stay is guaranteed to be unforgettable.
                    </p>
                </div>

                <!-- Inclusions -->
                <div class="space-y-6">
                    <h3 class="text-2xl font-serif font-bold">What's Included</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($cottage->inclusions as $inclusion)
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <span class="text-sea-500">✦</span>
                                <span class="text-slate-700 font-medium">{{ $inclusion->item_name }}</span>
                            </div>
                        @empty
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <span class="text-sea-500">✦</span>
                                <span class="text-slate-700 font-medium">Daily Beach Cleanup Access</span>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <span class="text-sea-500">✦</span>
                                <span class="text-slate-700 font-medium">Fresh Welcome Drinks</span>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <span class="text-sea-500">✦</span>
                                <span class="text-slate-700 font-medium">Complimentary Toiletries</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- House Rules -->
                <div class="p-8 rounded-[2rem] bg-sea-900 text-white space-y-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-sea-500/20 blur-3xl rounded-full"></div>
                    <h3 class="text-2xl font-serif font-bold relative z-10">Resort Policies</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                        <div class="space-y-2">
                            <span class="text-sea-400 font-bold text-xs uppercase tracking-widest">Arrival</span>
                            <p class="text-white/70">Check-in starts at 2:00 PM. Please present a valid ID upon arrival.</p>
                        </div>
                        <div class="space-y-2">
                            <span class="text-sea-400 font-bold text-xs uppercase tracking-widest">Departure</span>
                            <p class="text-white/70">Check-out is by 12:00 PM. Late check-out may be available upon request.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Booking Card (4 columns) -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl border border-slate-100 sticky top-32 space-y-8 animate-fade-in-up stagger-1">
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-4xl font-bold text-slate-900">₱{{ number_format($cottage->price, 0) }}</span>
                        <span class="text-slate-400 font-bold text-sm uppercase tracking-widest pb-1">per night</span>
                    </div>
                    <div class="flex items-center gap-2 text-amber-500">
                        <div class="flex">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <span class="text-slate-500 text-xs font-bold">120+ REVIEWS</span>
                    </div>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="cottage_id" value="{{ $cottage->id }}">
                    
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Guest Name</label>
                            <input type="text" name="customer_name" class="w-full rounded-2xl border-sand-100 bg-sand-50 px-6 py-4 focus:ring-2 focus:ring-sea-500/20 focus:border-sea-500 transition-all outline-none font-medium" placeholder="Your full name" required>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Email Address</label>
                            <input type="email" name="customer_email" class="w-full rounded-2xl border-sand-100 bg-sand-50 px-6 py-4 focus:ring-2 focus:ring-sea-500/20 focus:border-sea-500 transition-all outline-none font-medium" placeholder="hello@resort.com" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Check In</label>
                                <input type="text" name="check_in" id="check_in" class="flatpickr w-full rounded-2xl border-sand-100 bg-sand-50 px-4 py-4 focus:ring-2 focus:ring-sea-500/20 focus:border-sea-500 transition-all outline-none font-medium text-xs" required placeholder="Select date">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Check Out</label>
                                <input type="text" name="check_out" id="check_out" class="flatpickr w-full rounded-2xl border-sand-100 bg-sand-50 px-4 py-4 focus:ring-2 focus:ring-sea-500/20 focus:border-sea-500 transition-all outline-none font-medium text-xs" required placeholder="Select date">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Guests</label>
                                <select name="adults" class="w-full rounded-2xl border-sand-100 bg-sand-50 px-4 py-4 focus:ring-2 focus:ring-sea-500/20 focus:border-sea-500 transition-all outline-none font-medium text-xs">
                                    @for($i=1; $i<=$cottage->capacity; $i++)
                                        <option value="{{ $i }}">{{ $i }} Adult{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Contact</label>
                                <input type="text" name="customer_phone" class="w-full rounded-2xl border-sand-100 bg-sand-50 px-4 py-4 focus:ring-2 focus:ring-sea-500/20 focus:border-sea-500 transition-all outline-none font-medium text-xs" placeholder="09XX..." required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 space-y-4 border-t border-sand-100">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-400 font-medium">Service Fee</span>
                            <span class="text-slate-900 font-bold">₱0.00</span>
                        </div>
                        <div class="flex justify-between items-center text-2xl font-bold">
                            <span class="text-slate-900 font-serif">Estimated Total</span>
                            <span class="text-sea-600">₱<span id="display_total">{{ number_format($cottage->price, 0) }}</span></span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-resort w-full mt-4">
                        Confirm Reservation
                    </button>
                    
                    <div class="flex items-center gap-3 justify-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Secure Reservation System
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const pricePerNight = {{ $cottage->price }};
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const displayTotal = document.getElementById('display_total');

    function calculateTotal() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        
        if (checkIn && checkOut) {
            const start = new Date(checkIn);
            const end = new Date(checkOut);
            
            if (end <= start) {
                displayTotal.innerText = pricePerNight.toLocaleString();
                return;
            }

            const diffTime = Math.abs(end - start);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            const total = diffDays * pricePerNight;
            displayTotal.innerText = total.toLocaleString();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const fpCheckIn = flatpickr("#check_in", {
            minDate: "today",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                fpCheckOut.set("minDate", dateStr);
                calculateTotal();
            }
        });

        const fpCheckOut = flatpickr("#check_out", {
            minDate: new Date().fp_incr(1),
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                calculateTotal();
            }
        });
    });
</script>
@endsection
