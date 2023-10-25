<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gruppi - ') }} <span class="font-normal">{{ $post->group->name }}</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-group-menu :group="$post->group" />
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-1 -mt-1 flex justify-between items-center">
                        <h2 class="text-2xl font-semibold">{{ $post->title }}</h2>
                        <p class="text-gray-600 text-xs">{{ $post->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <p class="text-gray-700 text-justify">{{ $post->content }}</p>
                    @if ($post->attachments->count() > 0)
                        <div class="items-center px-4 py-1 mt-4 border-l-4 border-solid border-gray-500">
                            <div class="flex items-center mb-1">
                                <x-feathericon-paperclip class="h-4" />
                                <h2 class="text-base text-gray-500">Allegati:</h2><br>
                            </div>
                            <div>
                                @foreach ($post->attachments as $attachment)
                                    <a type="button" target="_blank" href="{{ route('attachments.show', ['group' => $group, 'post' => $post, 'attachment' => $attachment, 'attachment_name' => $attachment->file_name]) }}"
                                       class="px-2 py-1 m-1 text-white text-sm bg-gray-500 rounded-md hover:bg-gray-400 hover:underline">{{ $attachment->file_name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-sm text-gray-400 -mb-1">Scritto da {{ $post->user->name }} in
                            <a href="{{ route('groups.show', ['group' => $group]) }}" class="underline text-gray-700 hover:text-gray-500">{{ $post->group->name }}</a>
                        </p>
                        @if (auth()->user()->isAdmin() || auth()->user()->isAuthor($post))
                            <form action="{{ route('posts.destroy', ['group' => $group, 'post' => $post]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" onclick="return confirm('Sei sicuro di voler eliminare questo post?')">
                                    <!-- <x-feathericon-trash-2 /> -->
                                    Elimina
                                </x-danger-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-6 pb-6 mt-6">
                <form method="POST" action="{{ route('comments.store', ['group' => $group, 'post' => $post]) }}">
                    @csrf
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-semibold mb-4 my-4">
                            Commenti
                            <span class="inline-block bg-gray-700 text-white rounded px-1.5 -py-1 ml-1.5" style="font-size: 0.6em">
                                {{ $post->comments->count() }}
                            </span>
                        </h3>
                        <x-primary-button type="submit">
                            Commenta
                        </x-primary-button>
                    </div>
                    <textarea name="content" id="content" rows="3" class="shadow-md w-full px-4 py-2 border rounded border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-indigo-500" placeholder="Scrivi un commento" required></textarea>
                </form>
                @foreach($post->comments as $comment)
                        <x-comment :comment="$comment" />
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

