<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
            <a href="{{ route('staff.dashboard') }}" class="hover:text-slate-800">Staff</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-800 font-medium">Dashboard</span>
        </div>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">Operational Overview</h1>
            <div class="px-4 py-2 bg-amber-50 border border-amber-100 rounded-xl flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Live Operations</span>
            </div>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-10">
        <!-- Today's Check-ins -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 group hover:border-blue-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-full uppercase">Today</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Arrivals (Check-ins)</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $stats['today_checkins'] }}</h3>
        </div>

        <!-- Today's Check-outs -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 group hover:border-amber-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-full uppercase">Today</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Departures (Check-outs)</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $stats['today_checkouts'] }}</h3>
        </div>

        <!-- In-House Guests -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 group hover:border-purple-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-purple-500 bg-purple-50 px-2 py-1 rounded-full uppercase">Current</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">In-House Guests</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $stats['currently_in_house'] }}</h3>
        </div>

        <!-- Occupancy Rate -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 group hover:border-emerald-200 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-full uppercase">Current</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Occupancy Rate</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $stats['occupancy_rate'] }}%</h3>
        </div>

        <!-- Pending Payments -->
        <a href="{{ route('admin.bookings.index', ['status' => 'payment_pending']) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 group hover:border-rose-200 hover:shadow-md transition-all block">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-rose-500 bg-rose-50 px-2 py-1 rounded-full uppercase group-hover:bg-rose-100 transition-colors">Urgent</span>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Pending Payments</p>
            <h3 class="text-3xl font-bold text-slate-800">{{ $stats['pending_payments'] }}</h3>
        </a>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Recent Activity</h2>
                <p class="text-xs text-slate-500">Latest guest reservations and updates</p>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">View All Bookings</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/80 text-slate-500 text-[10px] uppercase tracking-widest">
                    <tr>
                        <th class="px-8 py-4 font-bold">Reference</th>
                        <th class="px-6 py-4 font-bold">Guest Details</th>
                        <th class="px-6 py-4 font-bold">Cottage</th>
                        <th class="px-6 py-4 font-bold">Stay Duration</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-8 py-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentBookings as $booking)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="font-mono text-sm font-bold text-slate-700 bg-slate-100 px-2 py-1 rounded-md">#{{ $booking->reference_number }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm font-bold text-slate-800">{{ $booking->customer_name }}</div>
                            <div class="text-xs text-slate-400">{{ $booking->customer_email }}</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                                <span class="text-sm font-medium text-slate-600">{{ $booking->cottage->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm text-slate-600 font-medium">
                                {{ $booking->check_in->format('M d') }} - {{ $booking->check_out->format('M d, Y') }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">
                                {{ $booking->check_in->diffInDays($booking->check_out) }} Nights
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-600 border border-green-100' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                                {{ $booking->status === 'checked_in' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-600 border border-red-100' : '' }}
                                {{ $booking->status === 'completed' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : '' }}
                            ">
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
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="p-2 text-slate-400 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-all inline-block">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-slate-400">
                            No recent activity found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
