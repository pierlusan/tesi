<x-guest-layout>
    <div class="mb-4 text-sm text-stone-300">
        {{ __('Hai dimenticato la password? Nessun problema. Basta inserire qui il tuo indirizzo e-mail e ti manderemo una mail con un link di reset per la password che ti permetterà di sceglierne una nuova.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="text-stone-100" :value="__('Email')" />
            <x-text-input id="email" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Invia Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
