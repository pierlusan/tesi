<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-100">
                    <h2 class="text-2xl font-semibold mb-4">I tuoi gruppi</h2>
                    @if (count($groups) > 0)
                        <ul class="list-none space-y-4">
                            @foreach ($groups as $group)
                                <li>
                                    <a href="{{ route('groups.show', $group) }}" class="block p-4 border rounded-lg border-gray-200 hover:bg-gray-100">
                                        <div class="mb-2">
                                            <span class="text-gray-900 font-semibold">{{ $group->name }}</span>
                                        </div>
                                        <div class="text-gray-600 text-sm">{{ $group->description }}</div>
                                        <div class="text-gray-400 text-xs">Creato il {{ $group->created_at->format('d/m/Y') }}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Non sei ancora membro di nessun gruppo.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
