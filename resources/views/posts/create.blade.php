<x-app-layout>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow-md">
        <h1 class="text-2xl font-semibold mb-6">Crea un nuovo post</h1>

        <form method="POST" action="{{ route('posts.store', ['group' => $group]) }}" class="space-y-4">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-600">Titolo</label>
                <!--<input type="hidden" name="group_id" value="{{ $group->id }}">-->
                <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-600">Contenuto</label>
                <textarea name="content" id="content" class="w-full border border-gray-300 rounded px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200" required></textarea>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Crea Post</button>
        </form>
    </div>
</x-app-layout>
