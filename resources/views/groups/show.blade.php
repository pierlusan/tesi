<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold mb-2" id="group-name-display">{{ $group->name }}</h2>
                        @if (auth()->user()->isAdmin())
                            <div class="ml-auto">
                                <button id="editGroupNameButton" class="bg-gray-600 hover:bg-gray-900 text-white font-semibold py-1 px-2 rounded shadow-md text-xs uppercase">
                                    Modifica
                                </button>
                                <button id="saveGroupName" class="bg-gray-600 hover:bg-gray-900 text-white font-semibold py-1 px-2 rounded shadow-md text-xs uppercase hidden">
                                    Salva
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="hidden" id="editGroupNameForm">
                        <input type="text" id="newGroupName" value="{{ $group->name }}" class="border rounded p-1">
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
    const editButton = document.getElementById('editGroupNameButton');
    const saveButton = document.getElementById('saveGroupName');
    const editGroupNameForm = document.getElementById('editGroupNameForm');
    const groupNameDisplay = document.getElementById('group-name-display');

    editButton.addEventListener('click', function () {
        groupNameDisplay.style.display = 'none';
        editGroupNameForm.style.display = 'block';
        editButton.style.display = 'none';
        saveButton.style.display = 'block';
    });

    saveButton.addEventListener('click', function () {
        const newGroupName = document.getElementById('newGroupName').value;
        const groupId = {{ $group->id }};

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
                groupNameDisplay.textContent = newGroupName;
                //groupNameDisplay.style.fontWeight = 'bold';
                //groupNameDisplay.style.color = '#000';

                editGroupNameForm.style.display = 'none';
                editButton.style.display = 'block';
                saveButton.style.display = 'none';
                groupNameDisplay.style.display ='block';
            })
            .catch((error) => {
                console.error('Errore durante l\'aggiornamento del nome del gruppo:', error);
            });
    });
</script>
