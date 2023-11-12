<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="text-stone-100" :value="__('Nome')" />
            <x-text-input id="name" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" class="text-stone-100" :value="__('Email')" />
            <x-text-input id="email" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" class="text-stone-100" :value="__('Password')" />

            <x-text-input id="password" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" class="text-stone-100" :value="__('Conferma Password')" />

            <x-text-input id="password_confirmation" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-stone-200 hover:text-stone-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Hai già un account?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Registrati') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
