<x-admin-layout>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl font-bold text-slate-900">Add New Staff Member</h1>
            <p class="mt-1 text-slate-500">Create a new account for your resort's administrative team.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            Back to Directory
        </a>
    </div>

    <div class="mx-auto max-w-3xl">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-4">
                <h2 class="font-semibold text-slate-800">Account Credentials</h2>
            </div>
            <div class="p-8">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="name" class="text-sm font-semibold text-slate-700">Full Name</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-user text-xs"></i>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                    required placeholder="e.g. John Doe">
                            </div>
                            @error('name') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1.5">
                            <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-envelope text-xs"></i>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                    class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                    required placeholder="john@example.com">
                            </div>
                            @error('email') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Role -->
                        <div class="space-y-1.5">
                            <label for="role_id" class="text-sm font-semibold text-slate-700">System Role</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-shield-halved text-xs"></i>
                                </div>
                                <select name="role_id" id="role_id" 
                                    class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role_id') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-1.5">
                            <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                                <input type="password" name="password" id="password" 
                                    class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                    required placeholder="••••••••">
                            </div>
                            @error('password') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Confirm Password</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-check-double text-xs"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="block w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                    required placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('admin.users.index') }}" 
                            class="rounded-xl px-6 py-2.5 text-sm font-semibold text-slate-600 transition-all hover:bg-slate-100">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="rounded-xl bg-slate-900 px-8 py-2.5 text-sm font-bold text-white shadow-lg shadow-slate-900/20 transition-all hover:bg-slate-800 active:scale-[0.98]">
                            Create Staff Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-8 rounded-2xl border border-blue-100 bg-blue-50/50 p-6 text-center">
            <p class="text-sm text-blue-800">
                <i class="fa-solid fa-circle-info mr-1"></i>
                New staff members will be able to log in immediately using their email and the provided password.
            </p>
        </div>
    </div>
</x-admin-layout>
