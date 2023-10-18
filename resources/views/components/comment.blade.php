@props(['comment'])

<div class="px-auto p-4 border rounded-lg border-gray-200 mt-4 shadow-md @if (auth()->check() && auth()->user()->id === $comment->user_id) bg-gray-100 hover:bg-white @else bg-white @endif">
    <div class="flex justify-between items-center -mt-1 mb-2">
        <p class="text-sm text-gray-500">{{ $comment->author->name }}</p>
        <p class="text-gray-400 text-xs">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <p class="text-gray-700">{{ $comment->content }}</p>

    @if (auth()->user()->isAdmin() || auth()->id() === $comment->user_id)
        <form method="POST" action="{{ route('comments.destroy', ['comment' => $comment]) }}">
            @csrf
            @method('DELETE')
            <div class="flex justify-end mt-2">
                <button style="font-size: 0.65rem" class="inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" type="submit" onclick="return confirm('Sei sicuro di voler eliminare il commento?')">
                    <!-- <x-feathericon-trash-2 class="h-3.5" /> -->Elimina
                </button>
            </div>
        </form>
    @endif
</div>
