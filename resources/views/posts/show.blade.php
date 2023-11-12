<x-app-layout>
    <div class="py-6" style="max-height: 89vh; overflow-y: auto;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-180 overflow-hidden shadow-md sm:rounded-lg" >
                <x-group-menu :group="$post->group" />
                <div class="p-6 backdrop-blur-800">
                    <div class="mb-1 -mt-1 flex justify-between items-center">
                        <h2 class="text-2xl text-stone-100 font-semibold">{{ $post->title }}</h2>
                        <p class="text-stone-400 text-xs">{{ $post->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <p class="text-stone-300 text-justify">{{ $post->content }}</p>
                    @if ($post->attachments->count() > 0)
                        <div class="items-center px-4 py-1 mt-4 border-l-4 border-solid border-stone-500">
                            <div class="flex items-center mb-1">
                                <x-feathericon-paperclip class="h-4 text-stone-400" />
                                <h2 class="text-base text-stone-400">Allegati:</h2><br>
                            </div>
                            <div>
                                @foreach ($post->attachments as $attachment)
                                    <a type="button" target="_blank" href="{{ route('attachments.show', ['group' => $group, 'post' => $post, 'attachment' => $attachment, 'attachment_name' => $attachment->file_name]) }}"
                                       class="px-2 py-1 m-1 text-white text-sm bg-stone-500 rounded-md hover:underline">{{ $attachment->file_name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-sm text-stone-400 -mb-1">Scritto da {{ $post->user->name }} in
                            <a href="{{ route('groups.show', ['group' => $group]) }}" class="underline text-stone-300 hover:text-stone-400">{{ $post->group->name }}</a>
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

            <div class="backdrop-blur-3xl overflow-hidden shadow-sm sm:rounded-lg px-6 pb-6 mt-6" >
                <form method="POST" enctype="multipart/form-data" action="{{ route('comments.store', ['group' => $group, 'post' => $post]) }}">
                    @csrf
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl text-stone-100 font-semibold my-4">
                            Commenti
                            <span class="inline-block bg-stone-700 text-white rounded px-1.5 -py-1 ml-1.5" style="font-size: 0.6em">
                                {{ $post->comments->count() }}
                            </span>
                        </h3>
                        <x-primary-button type="submit">
                            Commenta
                        </x-primary-button>
                    </div>
                    <div class="p-4 bg-stone-600 rounded-md shadow-md">
                        <div class="w-full mb-4">
                            <textarea name="content" id="content" rows="3" class="block mt-1 mb-4 bg-stone-300 border-stone-600 focus:border-stone-700 placeholder-stone-700 focus:ring-stone-700 shadow-md rounded-md w-full" placeholder="Scrivi un commento" required></textarea>
                        </div>
                        <div class="w-full mb-4">
                            <div class="mb-4">
                                <label for="attachments" class="block text-stone-100 mb-2">Allegati <span class="text-xs text-stone-100">(max: 128MB)</span></label>
                                <input type="file" name="attachments[]" id="attachments" class="w-full bg-stone-300 border border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md rounded-md file:mr-4 file:uppercase file:px-8 file:py-3 file:border-0 file:rounded-l-md file:font-semibold file:text-white file:text-xs file:tracking-widest file:bg-stone-800 hover:file:bg-stone-700 hover:file:cursor-pointer" multiple>
                            </div>
                        </div>
                    </div>
                </form>
                @foreach($post->comments as $comment)
                        <x-comment :comment="$comment" />
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

