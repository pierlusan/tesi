<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gruppi - ') }} <span class="font-normal">{{ $group->name }}</span>
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-group-menu  :group="$group" />
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ $group->name }} - Crea Evento</h1>

                    <form method="POST" action="{{ route('events.store', ['group' => $group]) }}" class="space-y-4">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-600">Titolo<span class="font-bold text-base text-red-600">*</span></label>
                            <x-text-input type="text" name="title" class="block w-full" id="title" required></x-text-input>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-600">Descrizione<span class="font-bold text-base text-red-600">*</span></label></label>
                            <textarea name="description" id="description" rows="2" class="block mt-1 w-full border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-gray-600">Data e ora<span class="font-bold text-base text-red-600">*</span></label>
                            <x-text-input type="datetime-local" name="date" class="block w-full" id="date" min="{{ now()->toDateString() . 'T' . now()->format('H:i') }}" required></x-text-input>
                        </div>

                        <!--
                        <div class="mb-4">
                            <label for="type" class="block text-gray-600">Tipologia</label>
                            <x-text-input type="text" name="type" class="block w-full" id="type"></x-text-input>
                        </div>
                        -->

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit">Pianifica Evento</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
