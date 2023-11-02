<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventi Personali - ') }}<span class="font-normal">{{ $singleEvent->title }}</span>
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-1 -mt-1 flex justify-between items-center">
                        @switch($singleEvent->status)
                            @case(\App\Enum\EventStatus::PLANNED)
                                <h2 class="text-xl font-semibold">In programma il <span class="text-amber-500">{{ $singleEvent->date->format('d/m/Y') }}</span> alle <span class="text-amber-500">{{ $singleEvent->date->format('H:i') }}</span></h2>
                                @break
                            @case(\App\Enum\EventStatus::ACTIVE)
                                <h2 class="text-xl font-semibold"><span class="text-emerald-500">Attivo</span> dalle <span class="text-emerald-500">{{ $singleEvent->date->format('H:i') }}</span></h2>
                                @break
                            @case(\App\Enum\EventStatus::COMPLETED)
                                <h2 class="text-xl font-semibold"><span class="text-indigo-500">Concluso</span> il <span class="text-indigo-500">{{ $singleEvent->date->format('d/m/Y') }}</span></h2>
                                @break
                            @case(\App\Enum\EventStatus::CANCELED)
                                <h2 class="text-xl font-semibold"><span class="text-red-500">Evento cancellato</span></h2>
                                @break
                        @endswitch
                        <p class="text-gray-600 text-xs">Creato il {{ $singleEvent->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <h2 class="text-2xl font-semibold">{{ $singleEvent->title }}</h2>
                    <p class="text-gray-700 text-justify">{{ $singleEvent->description }}</p>

                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-sm text-gray-400 -mb-1">Pianificato con {{ $singleEvent->client->name }}
                        </p>
                        @if (auth()->user()->isAdmin() && $singleEvent->status->isPlanned())
                            <form action="{{ route('single_events.cancel', ['singleEvent' => $singleEvent]) }}" method="POST">
                                @csrf
                                <x-danger-button type="submit" onclick="return confirm('Sei sicuro di voler annullare questo evento?')">
                                    <!-- <x-feathericon-trash-2 /> -->
                                    Cancella
                                </x-danger-button>
                            </form>
                        @elseif (auth()->user()->isAdmin() && $singleEvent->status->isCanceled())
                            <form action="{{ route('single_events.destroy', ['singleEvent' => $singleEvent]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" onclick="return confirm('Sei sicuro di voler eliminare definitivamente questo evento?')">
                                    <!-- <x-feathericon-trash-2 /> -->
                                    Elimina definitivamente
                                </x-danger-button>
                            </form>
                        @elseif (auth()->user()->isAdmin() && $singleEvent->status->isActive())
                            <form action="{{ route('single_events.end', ['singleEvent' => $singleEvent]) }}" method="POST">
                                @csrf
                                <x-danger-button type="submit" onclick="return confirm('Sei sicuro di voler terminare questo evento?')">
                                    <!-- <x-feathericon-trash-2 /> -->
                                    Termina
                                </x-danger-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
