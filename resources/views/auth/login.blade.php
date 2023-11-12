<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="text-stone-100" :value="__('Email')" />
            <x-text-input id="email" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" class="text-stone-100" :value="__('Password')" />

            <x-text-input id="password" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-stone-100 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-stone-200">{{ __('Ricordami') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-stone-200 hover:text-stone-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Hai dimenticato la password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Login') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
