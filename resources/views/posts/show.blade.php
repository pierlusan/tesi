<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-group-menu :group="$group" />
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-1 -mt-1 flex justify-between items-center">
                        <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
                        <p class="text-gray-600 text-xs">{{ $post->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <p class="text-gray-700">{{ $post->content }}</p>
                    <div class="mt-4">
                        <p class="text-sm text-gray-400 -mb-1">Scritto da {{ $post->user->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

