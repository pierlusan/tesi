<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventi Personali') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="pb-6 bg-white border-b border-gray-100 flex justify-between items-center">
                        <h1 class="text-2xl font-semibold"><span class="font-normal">Eventi personali</span></h1>
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
                                    <a href="{{ route('single_events.show', ['singleEvent' => $singleEvent]) }}" class="block p-4 border rounded-lg border-gray-200 shadow-md hover:bg-gray-100">
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
                                            <div class="col-span-10 pl-3 border-l-2 border-gray-300">
                                                <div class="mb-1">
                                                    <span class="text-gray-900 font-semibold">{{ $singleEvent->title }}</span>
                                                </div>
                                                <div class="text-gray-600 text-sm">
                                                    {{ $singleEvent->description }}
                                                </div>
                                                <div class="text-gray-400 text-sm mt-2">
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
