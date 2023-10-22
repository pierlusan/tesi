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
                        <h1 class="text-2xl font-semibold">{{ $group->name }} <span class="font-normal"> - Post</span></h1>
                        @if (auth()->user()->isAdmin())
                            <form action="{{ route('posts.create', ['group' => $group]) }}" method="GET">
                                <x-primary-button>Nuovo Post</x-primary-button>
                            </form>
                        @endif
                    </div>
                    @if ($posts->count() > 0)
                        <ul class="space-y-4">
                            @foreach ($posts as $post)
                                <li class="border rounded-lg p-4 shadow-md hover:bg-gray-100">
                                    <a href="{{ route('posts.show', ['group' => $group, 'post' => $post]) }}" class="hover:bg-gray-400">
                                        <div class="mb-1 -mt-1 flex justify-between items-center">
                                            <h2 class="font-semibold">{{ $post->title }}</h2>
                                            <p class="text-gray-600 text-xs">Inviato da {{ $post->user->name }} - {{ $post->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <p class="text-gray-700 text-sm">
                                            {{ strlen($post->content) > 400 ? substr($post->content, 0, 400) . '...' : $post->content }}
                                        </p>
                                        <div class="mt-2">
                                            @if ($post->comments->count() == 1)
                                                <p class="text-xs text-gray-400 -mb-1">{{ $post->comments->count() }} commento</p>
                                            @else
                                                <p class="text-xs text-gray-400 -mb-1">{{ $post->comments->count() }} commenti</p>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 border-transparent -mt-6">Ancora nessun post.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
