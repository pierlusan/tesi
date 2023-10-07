<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-100">
                    <h2 class="text-2xl font-semibold mb-4">Crea Gruppo</h2>

                    <form method="POST" action="{{ route('groups.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nome del gruppo')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <label for="users" class="block mb-1 text-sm font-medium text-gray-700">Aggiungi Utenti:</label>
                        <select multiple name="users[]" id="users" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4" onchange="console.log(this.selectedOptions)"  class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        <div class="mb-4">
                            <x-input-label for="description" class="mt-3" :value="__('Descrizione')" />
                            <textarea id="description" class="block h-32 mt-1 mb-4 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" required>{{ old('description') }}</textarea>
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

<!--
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usersDropdown = document.getElementById('users');
        const selectedUsersContainer = document.getElementById('selected-users');
        const addUserButton = document.getElementById('add-user-button');

        addUserButton.addEventListener('click', function () {
            const selectedOptions = Array.from(usersDropdown.selectedOptions);

            selectedOptions.forEach(option => {
                const userName = option.text;
                const userId = option.value;

                // Verifica se l'utente è già stato aggiunto
                if (!selectedUsersContainer.querySelector(`[data-user-id="${userId}"]`)) {
                    const userTag = document.createElement('div');
                    userTag.className = 'flex justify-between items-center bg-blue-500 text-white px-2 py-1 m-1 rounded';
                    userTag.setAttribute('data-user-id', userId);

                    const userNameElement = document.createElement('span');
                    userNameElement.textContent = userName;

                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'Rimuovi';
                    removeButton.className = 'ml-2 bg-red-500 text-white px-2 py-1 rounded';

                    removeButton.addEventListener('click', function () {
                        userTag.remove();
                        // Riaggiungi l'opzione selezionata al menu a tendina
                        usersDropdown.appendChild(option);
                    });

                    userTag.appendChild(userNameElement);
                    userTag.appendChild(removeButton);

                    selectedUsersContainer.appendChild(userTag);
                    // Rimuovi l'opzione selezionata dal menu a tendina
                    option.remove();
                }
            });
        });
    });
</script>
-->
