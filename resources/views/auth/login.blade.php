<x-guest-layout>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h3 class="text-xl font-bold text-gray-800 text-center mb-1">Masuk</h3>
    <p class="text-sm text-gray-500 text-center mb-6">Masuk ke akun Anda untuk melanjutkan</p>

    {{-- Google Login --}}
    <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors mb-4">
        <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
        Masuk dengan Google
    </a>
    <div class="flex items-center gap-3 mb-4">
        <div class="flex-1 border-t border-gray-100"></div>
        <span class="text-xs text-gray-400">atau</span>
        <div class="flex-1 border-t border-gray-100"></div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email Address --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-500 hover:text-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2.5 text-white font-medium rounded-lg transition-colors" style="background-color: #ca4e33;" onmouseover="this.style.backgroundColor='#b8432b'" onmouseout="this.style.backgroundColor='#ca4e33'">
                <i class="ri-login-box-line"></i> Masuk
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500">Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-700 transition-colors">Daftar sekarang</a></p>
    </div>
</x-guest-layout>
