<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg" style="max-height: 85.5vh; overflow-y: auto;">
                <div class="p-6 backdrop-blur-3xl">
                    <div class="pb-6 backdrop-blur-3xl flex justify-between items-center">
                        <h2 class="text-2xl text-stone-100 font-semibold">I tuoi gruppi</h2>
                        @if (Auth::user()->isAdmin())
                            <form action="{{ route('groups.create') }}" method="GET">
                                <x-primary-button>
                                    Crea gruppo
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                    @if (count($groups) > 0)
                        <ul class="list-none space-y-4">
                            @foreach ($groups as $group)
                                <li>
                                    <a href="{{ route('groups.show', $group) }}" class="block p-4 rounded-lg shadow-md bg-stone-500 hover:bg-stone-600 opacity-80 transition ease-in-out duration-150">
                                        <div class="mb-1">
                                            <span class="text-stone-100 font-semibold">{{ $group->name }}</span>
                                        </div>
                                        <div class="text-stone-300 text-sm">
                                            {{ strlen($group->description) > 400 ? substr($group->description, 0, 400) . '...' : $group->description }}
                                        </div>
                                        <div class="text-stone-400 text-xs mt-2">
                                            Creato il {{ $group->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-stone-300 font-semibold text-xs mt-2">
                                            Eventi in programma: {{ $group->events->whereIn('status', [\App\Enum\EventStatus::ACTIVE, \App\Enum\EventStatus::PLANNED])->count() }}
                                        </div>
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
