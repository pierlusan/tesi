<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold mb-2" id="groupName">{{ $group->name }}</h2>
                        @if (auth()->user()->isAdmin())
                            <div class="ml-auto">
                                <button id="editGroupNameButton" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-2 rounded shadow-md text-xs uppercase">
                                    Modifica
                                </button>
                            </div>
                        @endif
                        <button id="saveGroupName" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold mt-2 py-1 px-2 rounded shadow-md text-xs uppercase hidden">
                            Salva
                        </button>
                        <button id="cancelEdit" class="bg-red-600 hover:bg-red-700 text-white font-semibold mt-2 ml-2 py-1 px-2 rounded shadow-md text-xs uppercase hidden">
                            Annulla
                        </button>
                    </div>
                    <div class="hidden -mt-8" id="editGroupNameForm">
                        <input type="text" id="newGroupName" value="{{ $group->name }}" class="border rounded mb-2 p-1 text-xl">
                    </div>



                    <p class="text-gray-600 mb-4">
                        {{ $group->description }}
                    </p>


                    <p class="text-gray-600 mb-4">Data di Creazione: {{ $group->created_at->format('d/m/Y') }}</p>
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
    var groupId = {{ $group->id }};
    var csrfToken = '{{ csrf_token() }}'
</script>
@vite('resources/js/edit-group-name.js')
