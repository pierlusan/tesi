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
                    <div class="mb-1 -mt-1 flex justify-between items-center">
                        <h2 class="text-xl font-semibold">In programma il <span class="text-red-500">{{ $event->date->format('d/m/Y') }}</span> alle <span class="text-red-500">{{ $event->date->format('H:i') }}</span></h2>
                        <p class="text-gray-600 text-xs">In programma il {{ $event->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <h2 class="text-2xl font-semibold">{{ $event->title }}</h2>
                    <p class="text-gray-700 text-justify">{{ $event->description }}</p>

                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-sm text-gray-400 -mb-1">Pianificato da da {{ $event->user->name }} in
                            <a href="{{ route('groups.show', ['group' => $group]) }}" class="underline text-gray-700 hover:text-gray-500">{{ $event->group->name }}</a>
                        </p>
                        @if (auth()->user()->isAdmin())
                            <form action="{{ route('events.destroy', ['group' => $group, 'event' => $event]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" onclick="return confirm('Sei sicuro di voler cancellare questo evento?')">
                                    <!-- <x-feathericon-trash-2 /> -->
                                    Cancella
                                </x-danger-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
