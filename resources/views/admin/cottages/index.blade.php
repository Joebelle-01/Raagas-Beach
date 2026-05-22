<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800">Admin</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-800 font-medium">Cottages</span>
        </div>
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-slate-800">Manage Cottages</h1>
            <a href="{{ route('admin.cottages.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New Cottage
            </a>
        </div>
    </x-slot>

    <!-- Advanced Filters -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-[0.03] pointer-events-none">
            <i class="fas fa-filter text-8xl"></i>
        </div>
        <form action="{{ route('admin.cottages.index') }}" method="GET" class="relative z-10 flex flex-wrap items-end justify-between gap-6">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Status Filter -->
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Filter by Status</label>
                    <div class="relative group">
                        <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-amber-500 transition-colors"></i>
                        <select name="status" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-600 focus:ring-2 focus:ring-amber-500/20 py-3 pl-11 pr-10 min-w-[240px] appearance-none cursor-pointer hover:bg-slate-100 transition-all">
                            <option value="">All Cottages</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>🟢 Available</option>
                            <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>🟡 Booked</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>🔴 Maintenance</option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>📦 Archived / Trash</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.cottages.index') }}" class="px-6 py-3 rounded-2xl font-bold text-sm text-slate-400 hover:text-slate-600 transition-all">Reset</a>
            </div>
        </form>
    </div>

    <!-- Stats Summary for Cottages -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Units</p>
                <p class="text-xl font-bold text-slate-800">{{ $cottages->total() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Available</p>
                <p class="text-xl font-bold text-slate-800">{{ $cottages->where('status', 'available')->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Avg. Price</p>
                <p class="text-xl font-bold text-slate-800">₱ {{ number_format($cottages->avg('price'), 0) }}</p>
            </div>
        </div>
    </div>

    <!-- Cottages Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-bold uppercase tracking-[0.15em]">
                        <th class="px-8 py-5">Cottage Details</th>
                        <th class="px-8 py-5">Capacity</th>
                        <th class="px-8 py-5">Price per Night</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cottages as $cottage)
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="shrink-0">
                                        @if($cottage->images->count() > 0)
                                            <a href="{{ Storage::url($cottage->images->first()->image_path) }}" class="glightbox">
                                                <img src="{{ Storage::url($cottage->images->first()->image_path) }}" alt="{{ $cottage->name }}" class="w-20 h-14 object-cover rounded-xl shadow-sm group-hover:scale-105 transition-transform duration-500">
                                            </a>
                                        @else
                                            <div class="w-20 h-14 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] text-slate-400 font-bold uppercase">No Image</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">{{ $cottage->name }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase tracking-widest">ID: #{{ str_pad($cottage->id, 3, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-2 text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span class="text-sm font-bold">{{ $cottage->capacity }} Persons</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="text-sm font-bold text-slate-800">₱ {{ number_format($cottage->price, 2) }}</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-widest">Standard Rate</div>
                            </td>
                             <td class="px-8 py-5">
                                @if($cottage->trashed())
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border bg-slate-100 text-slate-600 border-slate-200">
                                        Archived
                                    </span>
                                @else
                                    @php
                                        $statusClasses = [
                                            'available' => 'bg-green-100 text-green-700 border-green-200',
                                            'booked' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'maintenance' => 'bg-red-100 text-red-700 border-red-200',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusClasses[$cottage->status] ?? 'bg-slate-100 border-slate-200' }}">
                                        {{ $cottage->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($cottage->trashed())
                                        <form action="{{ route('admin.cottages.restore', $cottage->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-white transition-all bg-white hover:bg-emerald-600 border border-emerald-200 hover:border-emerald-600 px-3.5 py-2 rounded-xl shadow-sm hover:shadow-lg active:scale-95" title="Restore Cottage">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H17"></path></svg>
                                                Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.cottages.purge', $cottage->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Permanently delete this cottage and all its inclusions/images? This action is irreversible.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:text-white transition-all bg-white hover:bg-rose-600 border border-rose-200 hover:border-rose-600 px-3.5 py-2 rounded-xl shadow-sm hover:shadow-lg active:scale-95" title="Purge Permanently">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Purge
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.cottages.edit', $cottage) }}" class="p-2 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-blue-600 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.cottages.destroy', $cottage) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this cottage?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-red-600 transition-colors" title="Archive Cottage">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-slate-800 mb-1">No Cottages Found</h4>
                                    <p class="text-sm text-slate-400">Start by adding your first resort unit.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($cottages->hasPages())
        <div class="mt-8">
            {{ $cottages->links() }}
        </div>
    @endif
</x-admin-layout>

