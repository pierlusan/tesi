<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-180 overflow-hidden shadow-md sm:rounded-lg" style="max-height: 85.5vh; overflow-y: auto;">
                <div class="backdrop-blur-180 p-6">
                    <div class="mb-1 -mt-1 flex justify-between items-center">
                        @switch($singleEvent->status)
                            @case(\App\Enum\EventStatus::PLANNED)
                                <h2 class="text-xl text-stone-100 font-semibold">In programma il <span class="text-amber-300">{{ $singleEvent->date->format('d/m/Y') }}</span> alle <span class="text-amber-300">{{ $singleEvent->date->format('H:i') }}</span></h2>
                                @break
                            @case(\App\Enum\EventStatus::ACTIVE)
                                <h2 class="text-xl text-stone-100 font-semibold"><span class="text-emerald-300">Attivo</span> dalle <span class="text-emerald-300">{{ $singleEvent->date->format('H:i') }}</span></h2>
                                @break
                            @case(\App\Enum\EventStatus::COMPLETED)
                                <h2 class="text-xl text-stone-100 font-semibold"><span class="text-indigo-300">Concluso</span> il <span class="text-indigo-300">{{ $singleEvent->date->format('d/m/Y') }}</span></h2>
                                @break
                            @case(\App\Enum\EventStatus::CANCELED)
                                <h2 class="text-xl text-stone-100 font-semibold"><span class="text-red-300">Evento cancellato</span></h2>
                                @break
                        @endswitch
                        <p class="text-stone-400 text-xs">Creato il {{ $singleEvent->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <h2 class="text-2xl text-stone-100 font-semibold">{{ $singleEvent->title }}</h2>
                    <p class="text-stone-300 text-justify">{{ $singleEvent->description }}</p>

                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-sm text-stone-400 -mb-1">Pianificato con {{ $singleEvent->client->name }}
                        </p>
                        <div class="flex justify-between items-center">
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
                            @elseif (auth()->user()->isAdmin() && $singleEvent->status->isCompleted())
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
                            @if ($singleEvent->status->isActive())
                                    <form id="singlecall__form" class="ml-2">
                                        <div class="form__field__wrapper">
                                            <input type="hidden" name="name" value="{{auth()->user()->name}}" />
                                        </div>
                                        <div class="form__field__wrapper">
                                            <input type="hidden" name="room"  value="singlecall" />
                                        </div>
                                        <div id="greenDot"></div>
                                        <x-primary-button type="submit">
                                            Vai alla lobby
                                        </x-primary-button>
                                    </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    var singleEventId = {{ $singleEvent->id }};
    let forms = document.getElementById('singlecall__form')
    let displayName = sessionStorage.getItem('display_name1')
    if(displayName){
        forms.name.value = displayName
    }
    forms.addEventListener('submit', (e) => {
            e.preventDefault()
            sessionStorage.setItem('display_name1', e.target.name.value)
            let inviteCode = e.target.room.value
            if(!inviteCode){
                inviteCode = String(Math.floor(Math.random() * 10000))
            }
            window.location.href = `/single-events/${singleEventId}/lobby?inviteCode=` + inviteCode;
        }
    )
</script>
