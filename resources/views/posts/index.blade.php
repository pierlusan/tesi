<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg">
                <x-group-menu :group="$group" />
                <div class="p-6 backdrop-blur-3xl" style="max-height: 77vh; overflow-y: auto;">
                    <div class="pb-6 backdrop-blur-3xl flex justify-between items-center">
                        <h1 class="text-2xl text-stone-100 font-semibold">{{ $group->name }} <span class="font-normal"> - Post</span></h1>
                        @if (auth()->user()->isAdmin()  || auth()->user()->isMember($group))
                            <form action="{{ route('posts.create', ['group' => $group]) }}" method="GET">
                                <x-primary-button>Nuovo Post</x-primary-button>
                            </form>
                        @endif
                    </div>
                    @if ($posts->count() > 0)
                        <ul class="space-y-4">
                            @foreach ($posts as $post)
                                <li class="rounded-lg p-4 shadow-md bg-stone-600 hover:bg-stone-700 transition ease-in-out duration-150">
                                    <a href="{{ route('posts.show', ['group' => $group, 'post' => $post]) }}" class="bg-stone-600 hover:bg-stone-700">
                                        <div class="mb-1 -mt-1 flex justify-between items-center">
                                            <h2 class="text-stone-100 font-semibold">{{ $post->title }}</h2>
                                            <p class="text-stone-300 text-xs">Inviato da {{ $post->user->name }} - {{ $post->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <p class="text-stone-300 text-sm">
                                            {{ strlen($post->content) > 400 ? substr($post->content, 0, 400) . '...' : $post->content }}
                                        </p>
                                        <div class="mt-2">
                                            @if ($post->comments->count() == 1)
                                                <p class="text-xs text-stone-400 -mb-1">{{ $post->comments->count() }} commento</p>
                                            @else
                                                <p class="text-xs text-stone-400 -mb-1">{{ $post->comments->count() }} commenti</p>
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
