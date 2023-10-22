<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gruppi - ') }} <span class="font-normal">{{ $group->name }}</span>
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-group-menu :group="$group" />
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="pb-6 bg-white border-b border-gray-100 flex justify-between items-center">
                        <h1 class="text-2xl font-semibold">{{ $group->name }} <span class="font-normal"> - Eventi</span></h1>
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
                                    <a href="{{ route('events.show', ['group' => $group, 'event' => $event]) }}" class="block p-4 border rounded-lg border-gray-200 shadow-md hover:bg-gray-100">
                                        <div class="mb-1">
                                            <span class="text-gray-900 font-semibold">{{ $event->title }}</span>
                                        </div>
                                        <div class="text-gray-600 text-sm">
                                            {{ $event->description }}
                                        </div>
                                        <div class="text-gray-400 text-sm mt-2">
                                            Data: {{ $event->date->format('d/m/Y H:i') }}
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
