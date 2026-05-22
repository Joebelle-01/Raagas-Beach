<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-bold text-slate-900">Activity Logs</h1>
            <p class="mt-1 text-slate-500">Monitor system changes and administrative actions.</p>
        </div>
        <div class="flex items-center gap-4">
            <button class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-filter text-xs"></i>
                Filter Logs
            </button>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-4 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800">System Audit Trail</h2>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Live Updates</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-[11px] font-bold uppercase tracking-widest text-slate-500">
                        <th class="px-8 py-4">Timestamp</th>
                        <th class="px-6 py-4">Administrator</th>
                        <th class="px-6 py-4">Action</th>
                        <th class="px-6 py-4">Event Details</th>
                        <th class="px-8 py-4">Network ID</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="group transition-colors hover:bg-slate-50/50">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-900">{{ $log->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs font-medium text-slate-400">{{ $log->created_at->format('H:i:s') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-600 ring-2 ring-white">
                                        {{ substr($log->user->name ?? 'S', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-900">{{ $log->user->name ?? 'System' }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">{{ $log->user->role ?? 'CORE' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $actionClass = match(strtolower($log->action)) {
                                        'create', 'store' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'update', 'edit' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'delete', 'destroy' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        'login' => 'bg-violet-50 text-violet-600 border-violet-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100'
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $actionClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="max-w-xs text-sm leading-relaxed text-slate-600 line-clamp-2" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </p>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-mono text-[11px] font-medium text-slate-400 bg-slate-50 px-2 py-1 rounded-md">
                                    {{ $log->ip_address }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-list-ul text-4xl mb-4 opacity-20"></i>
                                    <p class="text-sm font-medium">No activity logs found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="border-t border-slate-100 bg-slate-50/30 px-8 py-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-admin-layout>
