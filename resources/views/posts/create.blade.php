<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-sm sm:rounded-lg">
                <x-group-menu  :group="$group" />
                <div class="p-6 backdrop-blur-3xl">
                    <h1 class="text-2xl text-stone-100 font-semibold mb-4">{{ $group->name }} - Crea Post</h1>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('posts.store', ['group' => $group]) }}" class="space-y-4">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-stone-100">Titolo<span class="font-bold text-base text-red-600">*</span></label>
                            <!--<input type="hidden" name="group_id" value="{{ $group->id }}">-->
                            <x-text-input type="text" name="title" class="block bg-stone-400 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md w-full" id="title" required></x-text-input>
                        </div>

                        <div class="mb-6">
                            <label for="content" class="block text-stone-100">Contenuto<span class="font-bold text-base text-red-600">*</span></label>
                            <textarea name="content" id="content" rows="3" class="block mt-1 mb-4 bg-stone-400 border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md rounded-md w-full" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="attachments" class="block text-stone-100 mb-2">Allegati <span class="text-xs text-stone-100">(max: 128MB)</span></label>
                            <input type="file" name="attachments[]" id="attachments" class="w-full bg-stone-400 border border-stone-600 focus:border-stone-700 focus:ring-stone-700 shadow-md rounded-md file:mr-4 file:uppercase file:px-8 file:py-3 file:border-0 file:rounded-l-md file:font-semibold file:text-white file:text-xs file:tracking-widest file:bg-stone-800 hover:file:bg-stone-700 hover:file:cursor-pointer" multiple>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit" id="submitButton">Crea Post</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


