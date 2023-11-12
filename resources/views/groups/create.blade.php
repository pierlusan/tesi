<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 backdrop-blur-3xl">
                    <h2 class="text-2xl text-stone-100 font-semibold mb-4">Crea Gruppo</h2>

                    <form method="POST" action="{{ route('groups.store') }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" class="text-stone-100" :value="__('Nome del gruppo')" />
                            <x-text-input id="name" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md rounded-md mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <label for="users" class="block mb-1 text-sm font-medium text-stone-100">Aggiungi Utenti</label>
                        <select multiple name="users[]" id="users" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4" onchange="console.log(this.selectedOptions)"  class="mt-1 block w-full rounded-md shadow-md bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        <div class="mb-4">
                            <x-input-label for="description" class="text-stone-100 mt-1" :value="__('Descrizione')" />
                            <textarea id="description" class="block h-32 mt-1 mb-4 w-full bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md rounded-md" name="description" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit">Crea Gruppo</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite('resources/js/multiselect.js')
