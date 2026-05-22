<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-bold text-slate-900">Staff Management</h1>
            <p class="mt-1 text-slate-500">Manage administrative access and team roles.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-slate-900/20 transition-all hover:bg-slate-800 active:scale-[0.98]">
            <i class="fa-solid fa-plus text-xs"></i>
            Add New Staff
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-4">
            <h2 class="font-semibold text-slate-800">Team Directory</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-[11px] font-bold uppercase tracking-widest text-slate-500">
                        <th class="px-8 py-4">Employee</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Member Since</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="group transition-colors hover:bg-slate-50/50">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-lg font-bold text-slate-600 ring-2 ring-white">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @if($user->id === auth()->id())
                                            <div class="absolute -right-0.5 -bottom-0.5 h-4 w-4 rounded-full border-2 border-white bg-emerald-500"></div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-900">{{ $user->name }}</span>
                                        <span class="text-xs font-medium text-slate-500">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $roleColor = match(strtolower($user->role->name)) {
                                        'admin' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'manager' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100'
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $roleColor }}">
                                    {{ $user->role->name }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs font-semibold text-slate-600 italic">
                                    {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition-all hover:bg-slate-50 hover:text-blue-600 hover:shadow-sm">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                onclick="return confirm('Archive this staff member?')"
                                                class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition-all hover:bg-rose-50 hover:text-rose-600 hover:shadow-sm">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-slate-500 italic">
                                No staff members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="border-t border-slate-100 bg-slate-50/30 px-8 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
