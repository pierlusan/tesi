@props(['comment'])
<div class="bg-white px-auto p-4 border rounded-lg border-gray-200 mt-4">
    <p class="text-gray-700">{{ $comment->content }}</p>
    <div class="flex justify-between items-center -mb-2 mt-4">
        <p class="text-sm text-gray-400">Scritto da {{ $comment->author->name }}</p>
        <p class="text-gray-400 text-xs">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
    </div>
</div>

