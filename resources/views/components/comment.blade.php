@props(['comment'])

<div class="px-auto p-7 rounded-lg mt-4 shadow-md @if (auth()->check() && auth()->user()->id === $comment->user_id) bg-stone-700 hover:bg-stone-600 opacity-80 transition ease-in-out duration-150 @else bg-stone-600 opacity-80 @endif">
    <div class="flex justify-between items-center -mt-1 mb-2">
        <div class="flex items-center @if (auth()->check() && auth()->user()->id === $comment->user_id) text-base font-semibold text-stone-100 @else text-base text-stone-200 @endif">
            <x-feathericon-message-square class="h-5 mr-1 -ml-0.5" />
            <p class="">
                {{ $comment->author->name }}
            </p>
        </div>
        <div>
            <form method="POST" action="{{ route('comments.destroy', ['group' => $comment->post->group, 'post' => $comment->post, 'comment' => $comment]) }}">
                @csrf
                @method('DELETE')
                <div class="flex justify-end">
                    <p class="text-stone-400 text-xs">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                    @if (auth()->user()->isAdmin() || auth()->id() === $comment->user_id)
                        <button type="submit" class="text-red-500 ml-1 hover:text-red-400 hover:rounded" onclick="return confirm('Sei sicuro di voler eliminare il commento?')">
                            <x-feathericon-x class="h-6 -mt-1" />
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="mb-3 mt-1 text-justify">
        <p class="text-stone-300">{{ $comment->content }}</p>
    </div>
    @if ($comment->attachments->count() > 0)
        <div class="items-center px-3 py-2 mb-3 border-l-4 border-solid border-stone-400">
            <div class="flex items-center">
                <x-feathericon-paperclip class="h-3 -mr-0.5 text-stone-400" />
                <h2 class="text-xs text-stone-400">Allegati:</h2><br>
            </div>
            <div>
                @foreach ($comment->attachments as $attachment)
                    <a type="button" target="_blank" href="{{ route('attachments.show', ['group' => $comment->post->group, 'post' => $comment->post, 'attachment' => $attachment, 'attachment_name' => $attachment->file_name]) }}"
                       class="px-2 py-1 m-1 text-white text-2xs bg-stone-400 rounded-md hover:underline">{{ $attachment->file_name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    @if ($comment->replies->count() > 0)
        <div class="border-l-4 border-l-stone-400 ml-0 mb-4 bg-transparent space-y-2">
            @foreach($comment->replies as $reply)
                <div class="border-b-2 border-b-stone-400 px-4 py-2">
                    <div class="flex items-center mb-2 @if(auth()->check() && auth()->user()->id === $reply->user_id) text-sm font-semibold text-stone-100 @else text-sm text-stone-200 @endif">
                        <x-feathericon-corner-left-up class="h-4 -ml-1.5" />
                        <p class="">{{ $reply->author->name }}</p>
                    </div>
                    <div class="flex text-justify">
                        <p class="text-stone-300">{{ $reply->content }}</p>
                    </div>
                    <div class="flex justify-end items-center -mr-4">
                        <p class="text-xs text-stone-400 -mt-1">{{ $reply->created_at->format('d/m/Y H:i') }}</p>
                        @if (auth()->user()->isAdmin() || auth()->id() === $reply->user_id)
                            <form method="POST" action="{{ route('replies.destroy', ['group' => $comment->post->group, 'post' => $comment->post, 'comment' => $comment, 'reply' => $reply]) }}">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end">
                                    <button type="submit" class="text-red-500 ml-1 hover:text-red-400 hover:rounded" onclick="return confirm('Sei sicuro di voler eliminare il commento?')">
                                        <x-feathericon-x class="h-6 -mt-1" />
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <form method="post" action="{{ route('replies.store', ['group' => $comment->post->group, 'post' => $comment->post, 'comment' => $comment]) }}">
        @csrf
        <div class="-mt-2 mb-2">
            <textarea name="content" id="content" rows="2" class="shadow-md text-sm w-full px-4 py-2 mt-3 bg-stone-300 border-stone-600 focus:border-stone-700 placeholder-stone-700 focus:ring-stone-700 rounded-md" placeholder="Rispondi al commento di {{ $comment->author->name }}" required></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" style="font-size: 0.65rem" class="inline-flex items-center px-3 py-1.5 bg-stone-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-stone-700 focus:bg-stone-700 active:bg-stone-900 focus:outline-none focus:ring-2 focus:ring-stone-700 focus:ring-offset-2 transition ease-in-out duration-150">
                Rispondi
            </button>
        </div>
    </form>
</div>
