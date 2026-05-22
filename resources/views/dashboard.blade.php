<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-serif text-3xl text-slate-800 leading-tight">
                    {{ __('Guest Sanctuary Dashboard') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Manage your cottage bookings, view check-in schedules, and securely submit payment verifications.</p>
            </div>
            <a href="{{ route('cottages.index') }}" class="inline-flex items-center px-6 py-3 bg-sea-900 text-white rounded-full text-sm font-bold shadow-lg hover:bg-sea-300 hover:text-slate-900 transition-all">
                <span>Book Another Cottage</span>
                <span class="ml-2">🏝️</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-sand-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- Global Flash Alert Messages -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-sm animate-fade-in-up">
                    <span class="text-2xl">✨</span>
                    <div>
                        <p class="font-bold">Success!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-100 text-rose-800 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-sm animate-fade-in-up">
                    <span class="text-2xl">⚠️</span>
                    <div>
                        <p class="font-bold">Error Occurred</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-100 text-rose-800 px-6 py-5 rounded-2xl flex items-start gap-4 shadow-sm animate-fade-in-up">
                    <span class="text-2xl mt-0.5">⚠️</span>
                    <div>
                        <p class="font-bold text-slate-800">Please correct the following errors:</p>
                        <ul class="text-xs list-disc list-inside mt-1.5 space-y-1 text-rose-900 font-medium">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <p class="text-[10px] text-slate-400 mt-2 font-normal">
                            * Note: If you selected a file but it says the field is required, the file may exceed PHP's server upload size limit. Try a smaller image or compressed file.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Dynamic Greeting Banner -->
            @php
                $hour = date('H');
                $greeting = 'Good evening';
                if ($hour >= 5 && $hour < 12) {
                    $greeting = 'Good morning';
                } elseif ($hour >= 12 && $hour < 18) {
                    $greeting = 'Good afternoon';
                }
            @endphp
            <div class="glass-card p-8 md:p-12 relative overflow-hidden bg-gradient-to-r from-sea-900 to-slate-900 text-white shadow-2xl animate-fade-in-up">
                <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-sea-300/10 blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-sea-300/10 blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="space-y-4">
                        <span class="text-xs uppercase tracking-widest font-bold text-sea-300">Resort Guest Portal</span>
                        <h1 class="text-4xl md:text-5xl font-serif leading-none">{{ $greeting }}, <span class="text-sea-300 font-sans font-semibold">{{ auth()->user()->name }}</span>!</h1>
                        <p class="text-white/80 max-w-xl text-sm font-light">Welcome back to your private resort sanctuary panel. Below are your active and past cottage reservations at Raagas Beach Resort.</p>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-6 bg-white/5 backdrop-blur-md p-6 rounded-3xl border border-white/10 self-stretch md:self-auto items-center">
                        <div class="text-center px-4">
                            <span class="block text-2xl font-bold font-serif text-sea-300">{{ $bookings->count() }}</span>
                            <span class="text-[10px] text-white/60 font-black uppercase tracking-wider">Total</span>
                        </div>
                        <div class="text-center px-4 border-l border-white/10">
                            <span class="block text-2xl font-bold font-serif text-emerald-400">{{ $bookings->where('status', 'confirmed')->count() }}</span>
                            <span class="text-[10px] text-white/60 font-black uppercase tracking-wider">Active</span>
                        </div>
                        <div class="text-center px-4 border-l border-white/10">
                            <span class="block text-2xl font-bold font-serif text-amber-400">{{ $bookings->where('status', 'pending')->count() }}</span>
                            <span class="text-[10px] text-white/60 font-black uppercase tracking-wider">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Sanctuary Grid -->
            <div class="space-y-8">
                <h3 class="font-serif text-2xl text-slate-800 flex items-center gap-3">
                    <span>Your Cottage Reservations</span>
                    <span class="h-px bg-slate-200 flex-grow"></span>
                </h3>

                @forelse($bookings as $booking)
                    @php
                        $days = max(1, $booking->check_in->diffInDays($booking->check_out));
                        $hasPaymentProof = $booking->payments->count() > 0;
                        $latestPayment = $booking->payments->last();
                        
                        // Status badge colors
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-800 border-amber-200',
                            'confirmed' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                            'verified' => 'bg-blue-50 text-blue-800 border-blue-200',
                            'cancelled' => 'bg-rose-50 text-rose-800 border-rose-200',
                        ];
                        
                        $statusLabel = [
                            'pending' => 'Pending Verification',
                            'confirmed' => 'Reservation Confirmed',
                            'verified' => 'Payment Verified',
                            'cancelled' => 'Cancelled',
                        ];

                        $badgeColor = $statusColors[$booking->status] ?? 'bg-slate-50 text-slate-800 border-slate-200';
                        $label = $statusLabel[$booking->status] ?? ucfirst($booking->status);
                    @endphp

                    <div class="glass-card overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-8 border-sand-100 hover:shadow-2xl transition-all duration-500 animate-fade-in-up stagger-1">
                        <!-- Cottage Preview Image / Graphic -->
                        <div class="lg:col-span-4 h-64 lg:h-auto min-h-[16rem] relative overflow-hidden bg-slate-900">
                            @if($booking->cottage->images->count() > 0)
                                <img src="{{ Storage::url($booking->cottage->images->first()->image_path) }}" alt="{{ $booking->cottage->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-slate-900 to-sea-950 flex flex-col items-center justify-center p-8 text-center">
                                    <div class="bg-white/5 backdrop-blur-md w-14 h-14 rounded-2xl flex items-center justify-center border border-white/10 shadow-xl mb-3">
                                        <span class="text-white text-lg font-bold font-serif">RB</span>
                                    </div>
                                    <span class="text-white/40 text-[9px] font-black uppercase tracking-[0.2em]">RAAGAS BEACH RESORT</span>
                                    <span class="text-sea-300 font-serif text-xs italic">{{ $booking->cottage->name }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white space-y-1">
                                <span class="text-[10px] text-sea-300 font-black uppercase tracking-widest">Cottage Selection</span>
                                <h4 class="text-2xl font-serif font-bold">{{ $booking->cottage->name }}</h4>
                            </div>
                        </div>

                        <!-- Reservation Details -->
                        <div class="lg:col-span-8 p-8 flex flex-col justify-between">
                            <div class="space-y-6">
                                <!-- Top header row of reservation -->
                                <div class="flex flex-wrap justify-between items-start gap-4 pb-4 border-b border-slate-100">
                                    <div>
                                        <span class="text-xs text-slate-400 block font-bold tracking-tighter uppercase">Reference Number</span>
                                        <span class="font-mono text-base font-bold text-slate-700 bg-sand-100/50 px-3 py-1 rounded-lg border border-sand-200/50">{{ $booking->reference_number }}</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-4 py-1.5 border rounded-full text-xs font-bold uppercase tracking-wider shadow-sm {{ $badgeColor }}">
                                            {{ $label }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Grid of details -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                                    <div>
                                        <span class="text-xs text-slate-400 block font-bold uppercase tracking-tighter">Check-In</span>
                                        <span class="text-sm font-bold text-slate-800">{{ $booking->check_in->format('M d, Y') }}</span>
                                        <span class="text-xs text-slate-500 block">From 2:00 PM</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 block font-bold uppercase tracking-tighter">Check-Out</span>
                                        <span class="text-sm font-bold text-slate-800">{{ $booking->check_out->format('M d, Y') }}</span>
                                        <span class="text-xs text-slate-500 block">Before 12:00 PM</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 block font-bold uppercase tracking-tighter">Duration</span>
                                        <span class="text-sm font-bold text-slate-800">{{ $days }} {{ Str::plural('Night', $days) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 block font-bold uppercase tracking-tighter">Guests</span>
                                        <span class="text-sm font-bold text-slate-800">{{ $booking->adults }} Adults, {{ $booking->children }} Children</span>
                                    </div>
                                </div>

                                <!-- Price summary -->
                                <div class="bg-sand-50 border border-sand-100 rounded-2xl p-4 flex justify-between items-center">
                                    <span class="text-sm font-medium text-slate-600">Sanctuary Accommodation Amount</span>
                                    <span class="text-xl font-bold text-sea-900">₱ {{ number_format($booking->total_price, 2) }}</span>
                                </div>

                                <!-- Flow for pending payments -->
                                @if($booking->status === 'pending')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                                        <!-- Payment Info Instructions -->
                                        <div class="space-y-4">
                                            <h5 class="font-bold text-xs uppercase text-slate-700 tracking-wider flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sea-900"></span>
                                                Payment Transfer Options
                                            </h5>
                                            <div class="space-y-3 text-xs text-slate-600">
                                                <!-- GCash Option -->
                                                <div class="p-3 bg-white border border-slate-100 rounded-xl flex items-start gap-3">
                                                    <span class="text-lg">📱</span>
                                                    <div>
                                                        <span class="block font-bold text-slate-800">GCash Express Send</span>
                                                        <span class="block font-mono text-sea-900 font-bold">0912-345-6789</span>
                                                        <span class="block text-slate-400">Account Name: Raagas Beach Resort</span>
                                                    </div>
                                                </div>
                                                <!-- Bank Option -->
                                                <div class="p-3 bg-white border border-slate-100 rounded-xl flex items-start gap-3">
                                                    <span class="text-lg">🏦</span>
                                                    <div>
                                                        <span class="block font-bold text-slate-800">BDO Unibank Transfer</span>
                                                        <span class="block font-mono text-sea-900 font-bold">1234-5678-9012</span>
                                                        <span class="block text-slate-400">Account Name: Raagas Beach Resort</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Upload Form -->
                                        <div class="space-y-4">
                                            <h5 class="font-bold text-xs uppercase text-slate-700 tracking-wider flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sea-900"></span>
                                                Submit Payment Verification
                                            </h5>
                                            
                                            @if(!$hasPaymentProof)
                                                <form action="{{ route('bookings.payment', $booking->reference_number) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                                    @csrf
                                                    <div class="border-2 border-dashed border-sand-200 hover:border-sea-300 rounded-2xl p-4 text-center transition-colors relative cursor-pointer group bg-white/50">
                                                        <input type="file" name="payment_proof" id="payment_proof_{{ $booking->id }}" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(this, '{{ $booking->id }}')">
                                                        <div class="space-y-2" id="upload_preview_container_{{ $booking->id }}">
                                                            <div class="text-3xl text-slate-300 group-hover:scale-110 transition-transform">📄</div>
                                                            <div class="text-xs font-bold text-slate-700">Click to upload transaction receipt</div>
                                                            <div class="text-[10px] text-slate-400">JPEG, PNG, JPG, WEBP (Max 10MB)</div>
                                                        </div>
                                                        <div id="image_preview_box_{{ $booking->id }}" class="hidden">
                                                            <img id="image_preview_el_{{ $booking->id }}" src="" class="max-h-24 mx-auto object-contain rounded-lg border border-slate-100 shadow-sm">
                                                            <span class="block text-[10px] font-bold text-sea-900 mt-2">Selected image loaded</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <button type="submit" class="w-full py-3 bg-sea-300 text-sea-900 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-sea-900 hover:text-white transition-colors shadow-sm">
                                                        Submit Receipt
                                                    </button>
                                                </form>
                                            @else
                                                <div class="bg-amber-50/50 border border-amber-200/50 rounded-2xl p-4 text-center space-y-3">
                                                    <div class="text-3xl">⏳</div>
                                                    <div>
                                                        <span class="block font-bold text-xs text-amber-900 uppercase tracking-wide">Verification in Progress</span>
                                                        <span class="block text-[11px] text-amber-700/80 mt-1">Your proof of payment has been submitted and is currently being audited by resort concierge staff.</span>
                                                    </div>
                                                    @if($latestPayment && $latestPayment->proof_path)
                                                        <a href="{{ Storage::url($latestPayment->proof_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-[10px] font-bold text-sea-900 hover:underline">
                                                            <span>View Submitted Proof</span>
                                                            <span>↗️</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <!-- Verified / Confirmed Flow payment status displays -->
                                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-2 text-slate-500">
                                            <span>🛡️</span>
                                            <span>Reserve status secured by Raagas Beach Resort administration.</span>
                                        </div>
                                        @if($booking->payments->count() > 0 && $latestPayment && $latestPayment->proof_path)
                                            <a href="{{ Storage::url($latestPayment->proof_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sea-900 font-bold hover:underline">
                                                <span>View Audited Receipt</span>
                                                <span>↗️</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State Reservation Sanctuary -->
                    <div class="glass-card text-center py-20 px-8 max-w-2xl mx-auto space-y-6 shadow-xl animate-fade-in-up">
                        <div class="text-7xl animate-bounce-subtle">🐚</div>
                        <h4 class="font-serif text-3xl text-slate-800">Your Paradise Calendar is Open</h4>
                        <p class="text-slate-500 leading-relaxed text-sm">You do not have any cottage reservations registered under your account yet. Let us escape to the tropical breezes, white sands, and turquoise waters of Raagas!</p>
                        <div class="pt-4">
                            <a href="{{ route('cottages.index') }}" class="btn-primary-resort inline-block">Explore Resort Cottages</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input, bookingId) {
            const previewContainer = document.getElementById('upload_preview_container_' + bookingId);
            const previewBox = document.getElementById('image_preview_box_' + bookingId);
            const previewImageEl = document.getElementById('image_preview_el_' + bookingId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImageEl.src = e.target.result;
                    previewContainer.classList.add('hidden');
                    previewBox.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
