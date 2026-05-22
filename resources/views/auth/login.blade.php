<x-guest-layout>
    <div>
        <div class="mb-8 text-center animate-fade-in-up">
            <h2 class="text-3xl font-serif font-extrabold text-sea-900 tracking-tight">Unified Sanctuary Portal</h2>
            <p class="text-sand-600 mt-2 font-medium text-sm">Welcome back to Raagas Beach. Sign in to access your dashboard.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-fade-in-up stagger-1">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-sand-700 font-bold mb-1.5" />
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-sand-400 group-focus-within:text-sea-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                    </span>
                    <x-text-input id="email" class="block w-full pl-11" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="your.email@example.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Account Password')" class="text-sand-700 font-bold mb-1.5" />
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-sand-400 group-focus-within:text-sea-500 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </span>
                    <x-text-input id="password" class="block w-full pl-11"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password"
                                    placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded-lg border-sand-300 text-sea-600 shadow-sm focus:ring-sea-500 w-5 h-5 transition-all" name="remember">
                    <span class="ms-2.5 text-sm text-sand-600 group-hover:text-sand-900 transition-colors">{{ __('Keep me logged in') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-sea-600 hover:text-sea-700 font-bold transition-colors duration-200" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full py-4 text-base font-black uppercase tracking-widest shadow-xl">
                    {{ __('Secure Log In') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm text-sand-600 animate-fade-in-up stagger-2">
            <span>Don't have an account? </span>
            <a href="{{ route('register') }}" class="text-sea-600 hover:text-sea-700 font-bold transition-colors">
                Register here
            </a>
        </div>

        <div class="mt-8 pt-6 border-t border-sand-200 text-center animate-fade-in-up stagger-3">
            <p class="text-sand-500 text-xs font-medium uppercase tracking-tighter">
                Raagas Beach Resort • Unified Sanctuary Portal
            </p>
        </div>
    </div>
</x-guest-layout>
