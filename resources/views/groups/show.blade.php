<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-4">{{ $group->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $group->description }}</p>
                    <p class="text-gray-600 mb-4">Data di Creazione: {{ $group->created_at->format('d/m/Y H:i:s') }}</p>

                    <h3 class="text-lg font-semibold mb-2">Membri del Gruppo</h3>
                    <ul>
                        @foreach ($group->users as $user)
                            <li class="mb-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $user->name }}</span> -
                                        <span class="text-gray-600">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
