<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-stone-100">
            {{ __('Elimina Account') }}
        </h2>

        <p class="mt-1 text-sm text-stone-300">
            {{ __("Una volta che il tuo account viene eliminato, tutte le risorse e i dati ad esso associati verranno cancellati definitivamente. Prima di procedere con l'eliminazione del tuo account, ti preghiamo di scaricare tutti i dati o le informazioni che desideri conservare.") }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        onclick="return confirm('Sei sicuro di voler eliminare il tuo account? Una volta eliminato, tutti i dati relativi ad esso verranno persi.')"
    >{{ __('Elimina Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" class :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Sei sicuro di voler eliminare il tuo account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __( "Una volta che il tuo account viene eliminato, tutte le risorse e i dati ad esso associati verranno cancellati definitivamente. Prima di procedere con l'eliminazione del tuo account, ti preghiamo di scaricare tutti i dati o le informazioni che desideri conservare.") }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annulla') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Elimina') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
