<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold mb-2" id="groupName">{{ $group->name }}</h2>
                        @if (auth()->user()->isAdmin())
                            <div class="ml-auto">
                                <button id="editGroupButton" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-2 rounded shadow-md text-xs uppercase">
                                    Modifica
                                </button>
                            </div>
                        @endif
                        <button id="saveEdit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold mt-2 py-1 px-2 rounded shadow-md text-xs uppercase hidden">
                            Salva
                        </button>
                        <button id="cancelEdit" class="bg-red-600 hover:bg-red-700 text-white font-semibold mt-2 ml-2 py-1 px-2 rounded shadow-md text-xs uppercase hidden">
                            Annulla
                        </button>
                    </div>
                    <div class="hidden -mt-8" id="editGroupNameForm">
                        <input type="text" id="newGroupName" value="{{ $group->name }}" class="border-gray-300 font-semibold focus:border-indigo-500 focus:ring-indigo-500 shadow-sm border rounded mb-2 pl-3 p-1 text-xl">
                    </div>

                    <p id="groupDesc" class="text-gray-600 text-base mb-4">
                        {{ $group->description }}
                    </p>
                    <div class="hidden" id="editGroupDescForm">
                        <textarea id="newGroupDesc" class="h-32 mt-1 mb-4 w-full text-gray-600 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" required>{{ $group->description }}</textarea>
                    </div>

                    <form method="POST" action="{{ route('groups.add', ['group' => $group]) }}">
                        @csrf
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold mb-2 mt-4">Membri del Gruppo ({{ $group->users->count() }})</h3>
                            @if (auth()->user()->isAdmin() && $users->count())
                                <button type="submit" id="addUser" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold mb-3.5 py-1 px-2 rounded shadow-md text-xs uppercase">
                                    Aggiungi
                                </button>
                            @endif
                        </div>
                        @if (auth()->user()->isAdmin() && $users->count())
                            <select multiple name="users[]" id="users" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="4" onchange="console.log(this.selectedOptions)"  class="mt-1 hidden w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </form>

                    <ul class="mt-4">
                        @foreach ($group->users as $user)
                            <li class="mb-2 flex items-center">
                                @if (auth()->user()->isAdmin() && !$user->isAdmin())
                                    <form method="POST" action="{{ route('groups.remove', ['group' => $group, 'user' => $user]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mr-2 text-red-500 hover:text-red-700 hover:rounded" onclick="confirmRemove({{ $user->id }})">
                                            <x-feathericon-x />
                                        </button>
                                    </form>
                                @endif
                                <div>
                                    <div>
                                        <span class="font-semibold">{{ $user->name }}</span> -
                                        <span class="text-gray-600">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-gray-600 text-sm border-t-2 border-gray-300 pt-3 mt-6">Data di Creazione: {{ $group->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    function confirmRemove(userId) {
        var conferma = confirm(`Sei sicuro di voler rimuovere questo utente?`);
        if (conferma) {
            document.querySelector(`form[action="/groups/{{ $group->id }}/remove-user/${userId}"]`).submit();
        }
        else {
            event.preventDefault();
        }
    }
</script>

<script>
    var groupId = {{ $group->id }};
    var groupDesc = '{{ $group->description }}';
    var csrfToken = '{{ csrf_token() }}';
</script>

@vite([
    'resources/js/edit-group.js',
    'resources/js/multiselect.js',
])
