<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800">Admin</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-800 font-medium">Dashboard</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800">Resort Overview</h1>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-full">+12%</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Total Bookings</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_bookings'] }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-full">+8.4%</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Total Revenue</p>
            <p class="text-2xl font-bold text-slate-800">₱ {{ number_format($stats['total_revenue'], 2) }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="text-xs font-bold text-slate-400">Available</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Occupancy Rate</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_cottages'] > 0 ? round((($stats['total_cottages'] - $stats['available_cottages']) / $stats['total_cottages']) * 100) : 0 }}%</p>
        </div>

        <a href="{{ route('admin.bookings.index', ['status' => 'payment_pending']) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 block hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-50 text-red-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-full group-hover:bg-red-100 transition-colors">Urgent</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Pending Payments</p>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['pending_payments'] }}</p>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Bookings Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Recent Reservations</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-wider">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-xs font-bold uppercase tracking-widest">
                            <th class="px-6 py-4">Guest</th>
                            <th class="px-6 py-4">Cottage</th>
                            <th class="px-6 py-4">Stay</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentBookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-800">{{ $booking->customer_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->reference_number }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $booking->cottage->name }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('M d') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-100 text-amber-700',
                                            'confirmed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            'completed' => 'bg-blue-100 text-blue-700',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $statusClasses[$booking->status] ?? 'bg-slate-100' }}">
                                        {{ $booking->status }}
                                    </span>
                                    @if($booking->payment)
                                        <div class="mt-1.5 flex flex-wrap items-center gap-1.5">
                                            @if($booking->payment->status === 'pending')
                                                @if($booking->payment->proof_path)
                                                    <a href="{{ Storage::url($booking->payment->proof_path) }}" class="glightbox inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 hover:border-amber-300 transition-colors shadow-sm cursor-pointer animate-pulse" title="View Submitted Receipt for #{{ $booking->reference_number }}">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                        Receipt Submitted 👁️
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-100 shadow-sm">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                        Receipt Submitted
                                                    </span>
                                                @endif
                                            @elseif($booking->payment->status === 'verified')
                                                @if($booking->payment->proof_path)
                                                    <a href="{{ Storage::url($booking->payment->proof_path) }}" class="glightbox inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 hover:border-emerald-300 transition-colors shadow-sm cursor-pointer" title="View Verified Receipt for #{{ $booking->reference_number }}">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Verified 👁️
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Verified
                                                    </span>
                                                @endif
                                            @elseif($booking->payment->status === 'rejected')
                                                @if($booking->payment->proof_path)
                                                    <a href="{{ Storage::url($booking->payment->proof_path) }}" class="glightbox inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-extrabold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 hover:border-rose-300 transition-colors shadow-sm cursor-pointer" title="View Refused Receipt for #{{ $booking->reference_number }}">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        Refused 👁️
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-extrabold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-100 shadow-sm">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        Refused
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="p-2 hover:bg-slate-100 rounded-lg inline-block text-slate-400 hover:text-slate-800 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions & Status -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.bookings.index') }}" class="p-4 bg-slate-50 hover:bg-slate-100 rounded-xl transition-colors text-center group">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mx-auto mb-3 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">New Booking</span>
                    </a>
                    <a href="{{ route('admin.cottages.index') }}" class="p-4 bg-slate-50 hover:bg-slate-100 rounded-xl transition-colors text-center group">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mx-auto mb-3 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Cottages</span>
                    </a>
                </div>
            </div>

            <div class="bg-slate-900 p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-white mb-2">Resort Capacity</h3>
                    <p class="text-slate-400 text-xs mb-6">Real-time room availability</p>
                    
                    <div class="flex items-end gap-2 mb-2">
                        <span class="text-3xl font-bold text-white">{{ $stats['available_cottages'] }}</span>
                        <span class="text-slate-400 text-sm mb-1">/ {{ $stats['total_cottages'] }} Units Available</span>
                    </div>
                    
                    <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                        @php $percent = $stats['total_cottages'] > 0 ? ($stats['available_cottages'] / $stats['total_cottages']) * 100 : 0; @endphp
                        <div class="bg-amber-500 h-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-amber-500/10 rounded-full"></div>
                <div class="absolute -left-4 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
            </div>
        </div>
    </div>
</x-admin-layout>
