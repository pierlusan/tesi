<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg">
                <x-group-menu :group="$group" />
                <div class="p-6 backdrop-blur-3xl" style="max-height: 77vh; overflow-y: auto;">
                    <div class="pb-6 backdrop-blur-3xl flex justify-between items-center" >
                        <h1 class="text-2xl text-stone-100 font-semibold">{{ $group->name }} <span class="font-normal"> - Eventi</span></h1>
                        @if (Auth::user()->isAdmin())
                            <form action="{{ route('events.create', $group) }}" method="GET">
                                <x-primary-button>
                                    Pianifica evento
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                    @if (count($events) > 0)
                        <ul class="list-none space-y-4">
                            @foreach ($events as $event)
                                <li>
                                    <a href="{{ route('events.show', ['group' => $group, 'event' => $event]) }}" class="block bg-stone-500 hover:bg-stone-600 opacity-80 p-4 rounded-lg shadow-md transition ease-in-out duration-150">
                                        <div class="grid grid-cols-12">
                                            <div class="col-span-2 flex items-center justify-center mr-4">
                                                <span @class(['w-full py-3 mx-1 text-white text-center rounded-md text-2xs font-semibold uppercase tracking-widest',
                                                    'bg-amber-600' => $event->status->isPlanned(),
                                                    'bg-emerald-600' => $event->status->isActive(),
                                                    'bg-indigo-600' => $event->status->isCompleted(),
                                                    'bg-red-600' => $event->status->isCanceled(),])>
                                                    {{ $event->status }}
                                                </span>
                                            </div>
                                            <div class="col-span-10 pl-3 border-l-2 border-stone-400">
                                                <div class="mb-1">
                                                    <span class="text-stone-100 font-semibold">{{ $event->title }}</span>
                                                </div>
                                                <div class="text-stone-300 text-sm">
                                                    {{ $event->description }}
                                                </div>
                                                <div class="text-stone-400 text-sm mt-2">
                                                    Data: {{ $event->date->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Nessun evento disponibile al momento.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
