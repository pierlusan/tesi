<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-group-menu :group="$group" />
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">Elenco dei post:</h1>
                    @if ($posts->count() > 0)
                        <ul>
                            @foreach ($posts as $post)
                                <li class="mb-4">
                                    <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
                                    <p class="text-gray-600">{{ $post->content }}</p>
                                    <p class="text-sm text-gray-400">Scritto da {{ $post->user->name }} in {{ $post->group->name }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Ancora nessun post disponibile.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
