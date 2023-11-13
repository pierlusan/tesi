<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg" style="max-height: 85.5vh; overflow-y: auto;">
                <div class="p-6 backdrop-blur-3xl">
                    <div class="pb-6 backdrop-blur-3xl flex justify-between items-center">
                        <h1 class="text-2xl text-stone-100 font-semibold">Eventi personali</h1>
                        @if (Auth::user()->isAdmin())
                            <form action=" {{ route('single_events.create') }} " method="GET">
                                <x-primary-button>
                                    Pianifica evento singolo
                                </x-primary-button>
                            </form>
                        @endif
                    </div>
                    @if (count($singleEvents) > 0)
                        <ul class="list-none space-y-4">
                            @foreach ($singleEvents as $singleEvent)
                                <li>
                                    <a href="{{ route('single_events.show', ['singleEvent' => $singleEvent]) }}" class="block bg-stone-500 hover:bg-stone-600 opacity-80 p-4 rounded-lg shadow-md transition ease-in-out duration-150">
                                        <div class="grid grid-cols-12">
                                            <div class="col-span-2 flex items-center justify-center mr-4">
                                                <span @class(['w-full py-3 mx-1 text-white text-center rounded-md text-2xs font-semibold uppercase tracking-widest',
                                                    'bg-amber-600' => $singleEvent->status->isPlanned(),
                                                    'bg-emerald-600' => $singleEvent->status->isActive(),
                                                    'bg-indigo-600' => $singleEvent->status->isCompleted(),
                                                    'bg-red-600' => $singleEvent->status->isCanceled(),])>
                                                    {{ $singleEvent->status }}
                                                </span>
                                            </div>
                                            <div class="col-span-10 pl-3 border-l-2 border-stone-400">
                                                <div class="mb-1">
                                                    <span class="text-stone-100 font-semibold">{{ $singleEvent->title }}</span>
                                                </div>
                                                <div class="text-stone-300 text-sm">
                                                    {{ $singleEvent->description }}
                                                </div>
                                                <div class="text-stone-400 text-sm mt-2">
                                                    Insieme a {{ $singleEvent->client->name }}<br>
                                                    Data: {{ $singleEvent->date->format('d/m/Y H:i') }}
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
