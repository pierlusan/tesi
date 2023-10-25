@props(['comment'])

<div class="px-auto p-7 border rounded-lg border-gray-200 mt-4 shadow-md @if (auth()->check() && auth()->user()->id === $comment->user_id) bg-gray-100 hover:bg-white @else bg-white @endif">
    <div class="flex justify-between items-center -mt-1 mb-2">
        <div class="flex items-center @if (auth()->check() && auth()->user()->id === $comment->user_id) text-base font-semibold text-gray-900 @else text-base text-gray-500 @endif">
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
                    <p class="text-gray-400 text-xs">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                    @if (auth()->user()->isAdmin() || auth()->id() === $comment->user_id)
                        <button type="submit" class="text-red-600 ml-1 hover:text-red-400 hover:rounded" onclick="return confirm('Sei sicuro di voler eliminare il commento?')">
                            <x-feathericon-x class="h-6 -mt-1" />
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="mb-3 mt-1 text-justify">
        <p class="text-gray-700">{{ $comment->content }}</p>
    </div>
    @if ($comment->attachments->count() > 0)
        <div class="items-center px-3 py-2 mb-3 border-l-4 border-solid border-gray-500">
            <div class="flex items-center">
                <x-feathericon-paperclip class="h-3 -mr-0.5" />
                <h2 class="text-xs text-gray-500">Allegati:</h2><br>
            </div>
            <div>
                @foreach ($comment->attachments as $attachment)
                    <a type="button" target="_blank" href="{{ route('attachments.show', ['group' => $comment->post->group, 'post' => $comment->post, 'attachment' => $attachment, 'attachment_name' => $attachment->file_name]) }}"
                       class="px-2 py-1 m-1 text-white text-2xs bg-gray-500 rounded-md hover:bg-gray-400 hover:underline">{{ $attachment->file_name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    @if ($comment->replies->count() > 0)
        <div class="border-l-4 border-l-gray-800 ml-0 mb-4 bg-white space-y-2">
            @foreach($comment->replies as $reply)
                <div class="border-b-2 border-l-gray-400 px-4 py-2">
                    <div class="flex items-center mb-2 @if(auth()->check() && auth()->user()->id === $reply->user_id) text-sm font-semibold text-gray-900 @else text-sm text-gray-500 @endif">
                        <x-feathericon-corner-left-up class="h-4 -ml-1.5" />
                        <p class="">{{ $reply->author->name }}</p>
                    </div>
                    <div class="flex text-justify">
                        <p class="text-gray-700">{{ $reply->content }}</p>
                    </div>
                    <div class="flex justify-end items-center -mr-4">
                        <p class="text-xs text-gray-400 -mt-1">{{ $reply->created_at->format('d/m/Y H:i') }}</p>
                        @if (auth()->user()->isAdmin() || auth()->id() === $reply->user_id)
                            <form method="POST" action="{{ route('replies.destroy', ['group' => $comment->post->group, 'post' => $comment->post, 'comment' => $comment, 'reply' => $reply]) }}">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-end">
                                    <button type="submit" class="text-red-600 ml-1 hover:text-red-400 hover:rounded" onclick="return confirm('Sei sicuro di voler eliminare il commento?')">
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
            <textarea name="content" id="content" rows="2" class="shadow-sm text-sm w-full px-4 py-2 mt-3 border rounded border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-indigo-500" placeholder="Rispondi al commento di {{ $comment->author->name }}" required></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" style="font-size: 0.65rem" class="inline-flex items-center px-3 py-1.5 bg-gray-800 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Rispondi
            </button>
        </div>
    </form>
</div>
