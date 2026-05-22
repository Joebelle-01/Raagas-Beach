<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-bold text-slate-900">Sales & Analytics</h1>
            <p class="mt-1 text-slate-500">Track your resort's performance and revenue growth.</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.reports') }}" method="GET" class="flex items-center gap-2">
                <label for="year" class="text-sm font-medium text-slate-600 uppercase tracking-wider">Year:</label>
                <select name="year" id="year" onchange="this.form.submit()" 
                    class="rounded-xl border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                    @for($i = date('Y'); $i >= 2024; $i--)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </form>
            <button onclick="window.print()" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-print"></i>
            </button>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Lifetime Revenue -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="relative z-10">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-vault text-xl"></i>
                </div>
                <div class="text-sm font-medium text-slate-500">Lifetime Revenue</div>
                <div class="mt-1 flex items-baseline gap-1">
                    <span class="text-xl font-bold text-slate-900">₱</span>
                    <span class="text-3xl font-bold tracking-tight text-slate-900">{{ number_format($revenueSummary['total_lifetime'], 2) }}</span>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-slate-50 opacity-[0.05]">
                <i class="fa-solid fa-vault text-9xl"></i>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="relative z-10">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-chart-line text-xl"></i>
                </div>
                <div class="text-sm font-medium text-slate-500">Revenue This Month</div>
                <div class="mt-1 flex items-baseline gap-1">
                    <span class="text-xl font-bold text-slate-900">₱</span>
                    <span class="text-3xl font-bold tracking-tight text-slate-900">{{ number_format($revenueSummary['this_month'], 2) }}</span>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    @php
                        $diff = $revenueSummary['this_month'] - $revenueSummary['last_month'];
                        $isUp = $diff >= 0;
                    @endphp
                    <span class="flex items-center gap-1 rounded-full {{ $isUp ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} px-2 py-0.5 text-xs font-bold">
                        <i class="fa-solid {{ $isUp ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        ₱ {{ number_format(abs($diff), 2) }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium italic">vs last month</span>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-slate-50 opacity-[0.05]">
                <i class="fa-solid fa-chart-line text-9xl"></i>
            </div>
        </div>

        <!-- Booking Completion -->
        <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="relative z-10">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i class="fa-solid fa-calendar-check text-xl"></i>
                </div>
                <div class="text-sm font-medium text-slate-500">Completion Rate</div>
                @php
                    $rate = $bookingStats['total'] > 0 ? ($bookingStats['completed'] / $bookingStats['total']) * 100 : 0;
                @endphp
                <div class="mt-1 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-slate-900">{{ number_format($rate, 1) }}</span>
                    <span class="text-xl font-bold text-slate-900">%</span>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-600">{{ $bookingStats['completed'] }} completed</span>
                    <span class="text-slate-300">/</span>
                    <span class="text-xs font-semibold text-slate-400">{{ $bookingStats['total'] }} total bookings</span>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 text-slate-50 opacity-[0.05]">
                <i class="fa-solid fa-calendar-check text-9xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Revenue Trend Chart -->
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Revenue Growth</h2>
                    <p class="text-sm text-slate-500 italic">Monthly performance for the year {{ $year }}</p>
                </div>
                <div class="flex items-center gap-2 rounded-lg bg-slate-50 p-1">
                    <button class="rounded-md bg-white px-3 py-1 text-xs font-bold text-slate-900 shadow-sm transition-all">Monthly</button>
                    <button class="rounded-md px-3 py-1 text-xs font-bold text-slate-400 transition-all hover:text-slate-600">Quarterly</button>
                </div>
            </div>
            <div class="h-[300px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Booking Distribution -->
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="mb-2 text-lg font-bold text-slate-900">Booking Status</h2>
            <p class="mb-8 text-sm text-slate-500 italic">Breakdown of all reservations</p>
            
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="relative h-[220px] w-[220px]">
                    <canvas id="bookingStatusChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-bold text-slate-900">{{ $bookingStats['total'] }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</span>
                    </div>
                </div>
                
                <div class="flex-1 space-y-4 w-full">
                    @foreach([
                        ['status' => 'confirmed', 'label' => 'Confirmed', 'color' => 'bg-emerald-500', 'text' => 'text-emerald-600'],
                        ['status' => 'completed', 'label' => 'Completed', 'color' => 'bg-blue-500', 'text' => 'text-blue-600'],
                        ['status' => 'pending', 'label' => 'Pending', 'color' => 'bg-amber-500', 'text' => 'text-amber-600'],
                        ['status' => 'cancelled', 'label' => 'Cancelled', 'color' => 'bg-rose-500', 'text' => 'text-rose-600']
                    ] as $item)
                        <div class="group flex items-center justify-between rounded-xl border border-slate-50 bg-slate-50/50 px-4 py-3 transition-all hover:border-slate-200 hover:bg-white hover:shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="h-2.5 w-2.5 rounded-full {{ $item['color'] }}"></div>
                                <span class="text-sm font-semibold text-slate-700">{{ $item['label'] }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-slate-900">{{ $bookingStats[$item['status']] ?? 0 }}</span>
                                <span class="text-[10px] font-bold {{ $item['text'] }} opacity-0 transition-opacity group-hover:opacity-100 italic">
                                    {{ $bookingStats['total'] > 0 ? number_format(($bookingStats[$item['status']] ?? 0) / $bookingStats['total'] * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Set default font
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = '#64748b';

        // Revenue Chart
        const revCtx = document.getElementById('revenueChart').getContext('2d');
        const gradient = revCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($revenueData, 'month')) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode(array_column($revenueData, 'total')) !!},
                    borderColor: '#3b82f6',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '₱ ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) { return '₱' + (value >= 1000 ? (value/1000) + 'k' : value); }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Booking Status Chart
        const statusCtx = document.getElementById('bookingStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Confirmed', 'Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $bookingStats['confirmed'] ?? 0 }},
                        {{ $bookingStats['completed'] ?? 0 }},
                        {{ $bookingStats['pending'] ?? 0 }},
                        {{ $bookingStats['cancelled'] ?? 0 }}
                    ],
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                    hoverOffset: 10,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        displayColors: true,
                        cornerRadius: 8
                    }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
