<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold mb-2" id="group-name">{{ $group->name }}</h2>
                        @if (auth()->user()->isAdmin())
                            <div class="ml-auto">
                                <button id="editGroupNameButton" class="bg-gray-600 hover:bg-gray-900 text-white font-semibold py-1 px-2 rounded shadow-md text-xs uppercase">
                                    Modifica
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="hidden" id="editGroupNameForm">
                        <input type="text" id="newGroupName" value="{{ $group->name }}" class="border rounded p-1">
                        <button id="saveGroupName" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-xs uppercase">Salva</button>
                    </div>
                    <p class="text-gray-600 mb-4">
                        {{ $group->description }}
                    </p>


                    <p class="text-gray-600 mb-4">Data di Creazione: {{ $group->created_at->format('d/m/Y H:i:s') }}</p>
                    <h3 class="text-lg font-semibold mb-2">Membri del Gruppo</h3>
                    <ul>
                        @foreach ($group->users as $user)
                            <li class="mb-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $user->name }}</span> -
                                        <span class="text-gray-600">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('editGroupNameButton').addEventListener('click', function () {
        document.getElementById('group-name').style.display = 'none';
        document.getElementById('editGroupNameForm').style.display = 'block';
    });

    document.getElementById('saveGroupName').addEventListener('click', function () {
        const newGroupName = document.getElementById('newGroupName').value;
        const groupId = {{ $group->id }}; // Sostituisci con l'ID del gruppo

        // Esegui una richiesta AJAX per aggiornare il nome del gruppo
        fetch(`/groups/${groupId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ name: newGroupName }),
        })
            .then((response) => response.json())
            .then((data) => {
                // Aggiorna il nome visualizzato
                document.getElementById('group-name').textContent = newGroupName;

                // Nascondi il campo di input e il pulsante "Salva"
                document.getElementById('group-name').style.display = 'block';
                document.getElementById('editGroupNameForm').style.display = 'none';
            })
            .catch((error) => {
                console.error('Errore durante l\'aggiornamento del nome del gruppo:', error);
            });
    });
</script>
