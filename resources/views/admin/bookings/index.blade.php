<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800 transition-colors">Admin</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-slate-800 font-semibold tracking-tight">Reservations</span>
        </div>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Booking Folios</h1>
                <p class="text-slate-500 text-sm mt-1">Manage guest reservations and verify transactions.</p>
            </div>
            <div class="flex gap-3">
                <div class="flex items-center gap-2 bg-amber-50 px-4 py-2 rounded-xl border border-amber-100">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">{{ $bookings->total() }} Total Folios</span>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Advanced Filters -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-[0.03] pointer-events-none">
            <i class="fas fa-filter text-8xl"></i>
        </div>
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="relative z-10 flex flex-wrap items-end justify-between gap-6">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Status Filter -->
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Filter by Status</label>
                    <div class="relative group">
                        <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-amber-500 transition-colors"></i>
                        <select name="status" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-600 focus:ring-2 focus:ring-amber-500/20 py-3 pl-11 pr-10 min-w-[200px] appearance-none cursor-pointer hover:bg-slate-100 transition-all">
                            <option value="">All Reservations</option>
                            <option value="payment_pending" {{ request('status') == 'payment_pending' ? 'selected' : '' }}>💳 Receipt Submitted / Review Pending</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🕒 Pending Verification</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>✨ Confirmed Stay</option>
                            <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>🏨 Currently In-House</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>📦 Archived / Trash</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Search Guest Directory</label>
                    <div class="relative group">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-amber-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Email or Ref #..." class="bg-slate-50 border-none rounded-2xl text-sm font-medium text-slate-600 focus:ring-2 focus:ring-amber-500/20 py-3 pl-11 pr-4 min-w-[320px] hover:bg-slate-100 transition-all">
                    </div>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.bookings.index') }}" class="px-6 py-3 rounded-2xl font-bold text-sm text-slate-400 hover:text-slate-600 transition-all">Reset</a>
                <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 active:scale-95 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-xs opacity-70"></i>
                    Apply Criteria
                </button>
            </div>
        </form>
    </div>

    <!-- Reservations Collection -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] border-b border-slate-100">
                        <th class="px-8 py-6">Guest Information</th>
                        <th class="px-8 py-6">Accommodation</th>
                        <th class="px-8 py-6">Stay Period</th>
                        <th class="px-8 py-6">Payment Progress</th>
                        <th class="px-8 py-6">Folio Status</th>
                        <th class="px-8 py-6 text-right">Concierge</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm group-hover:bg-amber-100 group-hover:text-amber-600 transition-all duration-500 rotate-3 group-hover:rotate-0 shadow-sm group-hover:shadow-md">
                                        {{ substr($booking->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm tracking-tight">{{ $booking->customer_name }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[10px] font-mono text-slate-400 uppercase bg-slate-50 px-1.5 py-0.5 rounded group-hover:bg-white transition-colors">{{ $booking->reference_number }}</span>
                                            <span class="text-[10px] text-slate-300">•</span>
                                            <span class="text-[10px] text-slate-400 font-medium">{{ $booking->customer_phone }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $booking->cottage->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium tracking-wide">Premium Cottage</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <div class="text-sm font-bold text-slate-800">
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M') }} — {{ \Carbon\Carbon::parse($booking->check_out)->format('d M, Y') }}
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <i class="far fa-moon text-[9px] text-amber-500"></i>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} Night Stay</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $payment = $booking->payment;
                                    $paymentStatus = $payment ? $payment->status : 'none';
                                    $payConfig = [
                                        'none' => [
                                            'bgClass' => 'bg-slate-50',
                                            'textIconClass' => 'text-slate-500',
                                            'textLabelClass' => 'text-slate-600',
                                            'icon' => 'fa-circle-xmark',
                                            'label' => 'No Deposit'
                                        ],
                                        'pending' => [
                                            'bgClass' => 'bg-amber-50',
                                            'textIconClass' => 'text-amber-500',
                                            'textLabelClass' => 'text-amber-600',
                                            'icon' => 'fa-clock-rotate-left',
                                            'label' => 'Pending Review'
                                        ],
                                        'verified' => [
                                            'bgClass' => 'bg-emerald-50',
                                            'textIconClass' => 'text-emerald-500',
                                            'textLabelClass' => 'text-emerald-600',
                                            'icon' => 'fa-circle-check',
                                            'label' => 'Paid In Full'
                                        ],
                                        'rejected' => [
                                            'bgClass' => 'bg-rose-50',
                                            'textIconClass' => 'text-rose-500',
                                            'textLabelClass' => 'text-rose-600',
                                            'icon' => 'fa-circle-exclamation',
                                            'label' => 'Payment Refused'
                                        ],
                                    ][$paymentStatus] ?? [
                                        'bgClass' => 'bg-slate-50',
                                        'textIconClass' => 'text-slate-500',
                                        'textLabelClass' => 'text-slate-600',
                                        'icon' => 'fa-circle',
                                        'label' => $paymentStatus
                                    ];
                                @endphp
                                <div class="flex items-center gap-2.5">
                                    @if($booking->payment && $booking->payment->proof_path)
                                        <a href="{{ Storage::url($booking->payment->proof_path) }}" class="glightbox block relative group cursor-pointer" title="Verify Payment Proof for #{{ $booking->reference_number }}">
                                            <div class="w-8 h-8 rounded-lg overflow-hidden border border-slate-200 shadow-sm relative">
                                                <img src="{{ Storage::url($booking->payment->proof_path) }}" alt="Receipt" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                                    <i class="fas fa-eye text-white text-[10px]"></i>
                                                </div>
                                            </div>
                                            @if($booking->payment->status === 'pending')
                                                <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                                                </span>
                                            @endif
                                        </a>
                                    @else
                                        <div class="w-8 h-8 rounded-full {{ $payConfig['bgClass'] }} flex items-center justify-center {{ $payConfig['textIconClass'] }} text-xs">
                                            <i class="fas {{ $payConfig['icon'] }}"></i>
                                        </div>
                                    @endif
                                    <div class="flex flex-col">
                                        <span class="text-[11px] font-extrabold uppercase tracking-widest {{ $payConfig['textLabelClass'] }}">
                                            {{ $payConfig['label'] }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-serif italic">₱ {{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                     $statusClasses = [
                                         'pending' => 'bg-amber-50 text-amber-600 border-amber-100 shadow-amber-500/5',
                                         'confirmed' => 'bg-emerald-50 text-emerald-600 border-emerald-100 shadow-emerald-500/5',
                                         'checked_in' => 'bg-blue-50 text-blue-600 border-blue-100 shadow-blue-500/5',
                                         'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100 shadow-rose-500/5',
                                         'completed' => 'bg-indigo-50 text-indigo-600 border-indigo-100 shadow-indigo-500/5',
                                     ];
                                @endphp
                                @if($booking->trashed())
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-widest border shadow-sm bg-slate-100 text-slate-600 border-slate-200">
                                        Archived
                                    </span>
                                @else
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-extrabold uppercase tracking-widest border shadow-sm {{ $statusClasses[$booking->status] ?? 'bg-slate-50 border-slate-100' }}">
                                        {{ $booking->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    @if($booking->trashed())
                                        <form action="{{ route('admin.bookings.restore', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-600 hover:text-white transition-all bg-white hover:bg-emerald-600 border border-emerald-200 hover:border-emerald-600 px-4 py-2.5 rounded-2xl shadow-sm hover:shadow-lg active:scale-95">
                                                <i class="fas fa-trash-arrow-up text-[10px]"></i>
                                                Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.bookings.purge', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this booking folio? This action is irreversible.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-2 text-xs font-bold text-rose-600 hover:text-white transition-all bg-white hover:bg-rose-600 border border-rose-200 hover:border-rose-600 px-4 py-2.5 rounded-2xl shadow-sm hover:shadow-lg active:scale-95">
                                                <i class="fas fa-dumpster text-[10px]"></i>
                                                Purge
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-flex items-center gap-3 text-xs font-bold text-slate-600 hover:text-white transition-all bg-white hover:bg-slate-900 border border-slate-200 hover:border-slate-900 px-5 py-2.5 rounded-2xl shadow-sm hover:shadow-xl active:scale-95 group/btn">
                                        Manage Folio
                                        <i class="fas fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200 border-4 border-white shadow-inner">
                                        <i class="fas fa-calendar-times text-3xl"></i>
                                    </div>
                                    <h4 class="text-xl font-bold text-slate-800 mb-2">No Reservations Found</h4>
                                    <p class="text-sm text-slate-400 leading-relaxed">We couldn't find any reservation folios matching your current filter criteria.</p>
                                    <a href="{{ route('admin.bookings.index') }}" class="inline-block mt-6 text-xs font-bold text-amber-600 hover:text-amber-700 border-b border-amber-200 pb-1">Reset all filters</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($bookings->hasPages())
        <div class="mt-10">
            {{ $bookings->links() }}
        </div>
    @endif
</x-admin-layout>

