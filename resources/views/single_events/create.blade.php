<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">Crea evento personale</h1>

                    <form method="POST" action="{{ route('single_events.store') }}" class="space-y-4">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-600">Titolo<span class="font-bold text-base text-red-600">*</span></label>
                            <x-text-input type="text" name="title" class="block w-full" id="title" required></x-text-input>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-600">Descrizione<span class="font-bold text-base text-red-600">*</span></label></label>
                            <textarea name="description" id="description" rows="2" class="block mt-1 w-full border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                        </div>

                        <label for="users" class="block mb-1 text-sm font-medium text-gray-700">Seleziona utente</label>
                        <select  name="client" id="client" onchange="console.log(this.selectedOptions)"  class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach($users as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>

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

@vite('resources/js/multiselect.js')
