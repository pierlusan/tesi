<section>
    <header>
        <h2 class="text-lg font-medium text-stone-100">
            {{ __('Aggiorna Password') }}
        </h2>

        <p class="mt-1 text-sm text-stone-300">
            {{ __('Assicurati di utilizzare una password casuale per una maggior sicurezza.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" class="text-stone-200" :value="__('Password Attuale')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" class="text-stone-200" :value="__('Nuova Password')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" class="text-stone-200" :value="__('Conferma Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salva') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
