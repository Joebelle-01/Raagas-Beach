<x-dynamic-component :component="auth()->user()->role?->name === 'customer' ? 'app-layout' : 'admin-layout'">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="font-serif text-3xl font-bold text-slate-800 leading-tight">Account Settings</h1>
                <p class="mt-1 text-sm text-slate-500">Manage your profile information and security preferences.</p>
            </div>
            @if(auth()->user()->role?->name === 'customer')
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-sea-900 text-white rounded-full text-sm font-bold shadow-lg hover:bg-sea-300 hover:text-slate-900 transition-all gap-2 duration-300">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                    </svg>
                    <span>Back to Dashboard</span>
                </a>
            @endif
        </div>
    </x-slot>

    <div class="{{ auth()->user()->role?->name === 'customer' ? 'py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8' : '' }}">
        <div class="max-w-4xl space-y-8">
            <!-- Profile Information -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-4">
                    <h2 class="font-semibold text-slate-800">Profile Information</h2>
                </div>
                <div class="p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-4 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-blue-500 text-sm"></i>
                    <h2 class="font-semibold text-slate-800">Security & Password</h2>
                </div>
                <div class="p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="overflow-hidden rounded-2xl border border-rose-100 bg-rose-50/20 shadow-sm">
                <div class="border-b border-rose-100 bg-rose-50 px-8 py-4 flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm"></i>
                    <h2 class="font-semibold text-rose-800">Danger Zone</h2>
                    <span class="text-xs text-rose-500 font-medium bg-rose-100/50 px-2 py-0.5 rounded-full ml-auto">Irreversible Action</span>
                </div>
                <div class="p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
