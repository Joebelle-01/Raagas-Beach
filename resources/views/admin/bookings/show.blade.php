<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800 transition-colors">Admin</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <a href="{{ route('admin.bookings.index') }}" class="hover:text-slate-800 transition-colors">Reservations</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-slate-800 font-semibold tracking-tight">Folio #{{ $booking->reference_number }}</span>
        </div>
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Reservation Detail</h1>
                <p class="text-slate-500 text-sm mt-1">Review guest information and manage stay lifecycle.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.bookings.index') }}" class="bg-white text-slate-600 px-6 py-3 rounded-2xl font-bold text-sm border border-slate-200 hover:bg-slate-50 transition-all flex items-center gap-2 print:hidden">
                    <i class="fas fa-arrow-left text-xs opacity-50"></i>
                    Back to Collection
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Guest Folio (Left 2/3) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Guest Identity Card -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-slate-900 flex items-center justify-center text-white text-xl font-bold shadow-xl shadow-slate-900/10">
                            {{ substr($booking->customer_name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 tracking-tight">{{ $booking->customer_name }}</h2>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <i class="fas fa-envelope text-[10px]"></i>
                                    {{ $booking->customer_email }}
                                </span>
                                <span class="text-slate-200">|</span>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <i class="fas fa-phone text-[10px]"></i>
                                    {{ $booking->customer_phone }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] block mb-1">Reference No.</span>
                        <span class="text-lg font-mono font-bold text-slate-900 bg-amber-50 px-3 py-1 rounded-lg border border-amber-100">{{ $booking->reference_number }}</span>
                    </div>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Accommodation</p>
                        <p class="text-sm font-bold text-slate-800">{{ $booking->cottage->name }}</p>
                        <p class="text-xs text-slate-500">Luxury Garden View</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Check-In Date</p>
                        <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</p>
                        <p class="text-xs text-slate-500">Standard 2:00 PM</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Check-Out Date</p>
                        <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</p>
                        <p class="text-xs text-slate-500">Standard 12:00 PM</p>
                    </div>
                </div>
            </div>

            <!-- Financials & Payment Proof -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-3">
                        <i class="fas fa-receipt text-amber-500"></i>
                        Folio Financials
                    </h3>
                    <div class="text-2xl font-serif font-bold text-slate-900">
                        ₱ {{ number_format($booking->total_price, 2) }}
                    </div>
                </div>
                
                <div class="p-8">
                    @if($booking->payment)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            <!-- Payment Details -->
                            <div class="space-y-6">
                                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                    <div class="flex justify-between items-start mb-6">
                                        <div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Transaction Ref</p>
                                            <p class="text-sm font-mono font-bold text-slate-700">{{ $booking->payment->transaction_id ?? 'N/A' }}</p>
                                        </div>
                                        @php
                                            $payStatus = $booking->payment->status;
                                            $payStatusClass = [
                                                'pending' => 'bg-amber-100 text-amber-600',
                                                'verified' => 'bg-emerald-100 text-emerald-600',
                                                'rejected' => 'bg-rose-100 text-rose-600',
                                            ][$payStatus] ?? 'bg-slate-100 text-slate-600';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest {{ $payStatusClass }}">
                                            {{ $payStatus }}
                                        </span>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-slate-400 font-medium">Sub-total</span>
                                            <span class="text-slate-600 font-bold font-serif">₱ {{ number_format($booking->total_price, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-xs">
                                            <span class="text-slate-400 font-medium">Service Charge</span>
                                            <span class="text-slate-600 font-bold font-serif">₱ 0.00</span>
                                        </div>
                                        <div class="pt-3 border-t border-slate-200 flex justify-between text-sm">
                                            <span class="text-slate-900 font-bold">Total Settled</span>
                                            <span class="text-amber-600 font-bold font-serif">₱ {{ number_format($booking->total_price, 2) }}</span>
                                        </div>
                                    </div>
                                                                @if($booking->payment && $booking->payment->status === 'pending')
                                    <div class="flex flex-col gap-4">
                                        <form action="{{ route('admin.payments.verify', $booking->payment) }}" method="POST" class="space-y-4">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="verified">
                                            
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Verified Amount (₱)</label>
                                                <input type="number" name="verified_amount" step="0.01" value="{{ $booking->total_price }}" class="w-full bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500/20 py-3 px-4 outline-none" required>
                                            </div>

                                            <button type="submit" class="w-full bg-emerald-600 text-white px-6 py-4 rounded-2xl font-bold text-sm hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/10 active:scale-[0.98] flex items-center justify-center gap-2">
                                                <i class="fas fa-check-circle"></i>
                                                Verify Payment
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.payments.verify', $booking->payment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="w-full bg-white text-rose-600 px-6 py-4 rounded-2xl font-bold text-sm border border-rose-200 hover:bg-rose-50 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                                                <i class="fas fa-times-circle"></i>
                                                Reject Proof
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <!-- Proof Image -->
                            <div class="relative group">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Official Proof of Payment</p>
                                <a href="{{ Storage::url($booking->payment->proof_path) }}" class="glightbox block relative rounded-3xl overflow-hidden shadow-2xl shadow-slate-200 ring-8 ring-slate-50 group-hover:ring-amber-50 transition-all duration-500">
                                    <img src="{{ Storage::url($booking->payment->proof_path) }}" alt="Payment Proof" class="w-full h-auto object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/40 flex items-center justify-center transition-all duration-500">
                                        <div class="bg-white/90 backdrop-blur px-6 py-3 rounded-2xl font-bold text-sm text-slate-900 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 flex items-center gap-2">
                                            <i class="fas fa-search-plus text-xs"></i>
                                            Inspect Document
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="py-12 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm">
                                <i class="fas fa-file-invoice-dollar text-2xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Waiting for Guest Deposit</p>
                            <p class="text-xs text-slate-400 mt-1 max-w-[240px] mx-auto">The guest has not yet uploaded their GCash or Bank Transfer proof.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions & Timeline (Right 1/3) -->
        <div class="space-y-8">
            <!-- Folio Control Center -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden print:hidden">
                <div class="p-6 border-b border-slate-50">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-cog text-slate-400"></i>
                        Folio Controls
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Current Folio Status</label>
                            <div class="relative">
                                <select name="status" class="w-full bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-amber-500/20 py-3.5 px-4 appearance-none cursor-pointer">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>🕒 Pending Verification</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>✨ Confirmed Reservation</option>
                                    <option value="checked_in" {{ $booking->status === 'checked_in' ? 'selected' : '' }}>🏨 Currently In-House</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled / Void</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>✅ Checkout Complete</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-slate-900 text-white px-6 py-4 rounded-xl font-bold text-sm hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 active:scale-[0.98]">
                            Update Folio Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stay Summary Card -->
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-calendar-day text-slate-400"></i>
                        Stay Summary
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <span class="text-xs text-slate-500 font-medium">Adults</span>
                        <span class="text-sm font-bold text-slate-800">{{ $booking->adults }} Guests</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-50">
                        <span class="text-xs text-slate-500 font-medium">Children</span>
                        <span class="text-sm font-bold text-slate-800">{{ $booking->children }} Guests</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-xs text-slate-500 font-medium">Total Nights</span>
                        <span class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} Nights</span>
                    </div>
                </div>
            </div>

            <!-- Operational Actions -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="fas fa-bolt text-blue-500"></i>
                    Quick Actions
                </h3>
                <div class="space-y-3 print:hidden">
                    <button onclick="window.print()" class="w-full flex items-center justify-between px-5 py-4 bg-slate-50 hover:bg-slate-100 rounded-2xl font-bold text-slate-700 text-sm transition-all group">
                        Print Folio Receipt
                        <i class="fas fa-print text-slate-400 group-hover:text-slate-800 transition-colors"></i>
                    </button>
                    <button onclick="alert('Concierge email system is active. Notification will be re-sent to: {{ $booking->customer_email }}')" class="w-full flex items-center justify-between px-5 py-4 bg-slate-50 hover:bg-slate-100 rounded-2xl font-bold text-slate-700 text-sm transition-all group">
                        Send Concierge Email
                        <i class="fas fa-envelope text-slate-400 group-hover:text-slate-800 transition-colors"></i>
                    </button>
                    @if($booking->trashed())
                        <form action="{{ route('admin.bookings.restore', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between px-5 py-4 bg-emerald-50 hover:bg-emerald-100 rounded-2xl font-bold text-emerald-600 text-sm transition-all group">
                                Restore Reservation
                                <i class="fas fa-trash-arrow-up text-emerald-400 group-hover:text-emerald-600 transition-colors"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.bookings.purge', $booking->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to permanently delete this reservation? This cannot be undone.')" class="w-full flex items-center justify-between px-5 py-4 bg-rose-50 hover:bg-rose-100 rounded-2xl font-bold text-rose-600 text-sm transition-all group">
                                Purge Reservation (Delete)
                                <i class="fas fa-dumpster text-rose-400 group-hover:text-rose-600 transition-colors"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to archive this reservation? It will be moved to the archive folder.')" class="w-full flex items-center justify-between px-5 py-4 bg-slate-50 hover:bg-slate-100 rounded-2xl font-bold text-slate-700 text-sm transition-all group">
                                Archive Reservation (Delete)
                                <i class="fas fa-archive text-slate-400 group-hover:text-slate-700 transition-colors"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" onclick="return confirm('Are you sure you want to void this reservation?')" class="w-full flex items-center justify-between px-5 py-4 bg-rose-50 hover:bg-rose-100 rounded-2xl font-bold text-rose-600 text-sm transition-all group">
                                Void Reservation
                                <i class="fas fa-trash-alt text-rose-400 group-hover:text-rose-600 transition-colors"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Reservation Timeline -->
            <div class="bg-slate-900 p-8 rounded-[2rem] shadow-xl relative overflow-hidden print:hidden">
                <div class="relative z-10">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-8">System Activity</h3>
                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div class="relative">
                                <div class="w-3 h-3 bg-amber-500 rounded-full z-10 relative border-4 border-slate-900"></div>
                                <div class="absolute top-3 bottom-0 left-[5px] w-px bg-slate-700"></div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Guest Created Reservation</p>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">{{ $booking->created_at->format('M d, Y @ h:i A') }}</p>
                            </div>
                        </div>

                        @foreach($booking->payments as $payment)
                            <div class="flex gap-4">
                                <div class="relative">
                                    <div class="w-3 h-3 bg-emerald-500 rounded-full z-10 relative border-4 border-slate-900"></div>
                                    @if(!$loop->last) <div class="absolute top-3 bottom-0 left-[5px] w-px bg-slate-700"></div> @endif
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-white">Payment Submission #{{ $loop->iteration }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">{{ $payment->created_at->format('M d, Y @ h:i A') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Background Glow -->
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-amber-500/10 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>
</x-admin-layout>
