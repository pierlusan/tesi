<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-group-menu  :group="$group" />
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold mb-4">{{ $group->name }} - Crea Post</h1>

                    <form method="POST" enctype="multipart/form-data" action="{{ route('posts.store', ['group' => $group]) }}" class="space-y-4">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-600">Titolo<span class="font-bold text-base text-red-600">*</span></label>
                            <!--<input type="hidden" name="group_id" value="{{ $group->id }}">-->
                            <x-text-input type="text" name="title" class="block w-full" id="title" required></x-text-input>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-gray-600">Contenuto<span class="font-bold text-base text-red-600">*</span></label>
                            <textarea name="content" id="content" class="block h-32 mt-1 mb-4 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="attachments" class="block text-gray-600 mb-2">Allegati</label>
                            <input type="file" name="attachments[]" id="attachments" multiple>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit">Crea Post</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
