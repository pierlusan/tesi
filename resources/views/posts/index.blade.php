<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-gray-500 px-8 pb-1 pt-3 border-b border-gray-300 flex justify-left space-x-4">
                    <x-nav-link-group :href="route('groups.show', ['group' => $group])"
                                      :active="request()->routeIs('groups.show')">
                        {{ __('Home') }}
                    </x-nav-link-group>
                    <x-nav-link-group :href="route('posts.index', ['group' => $group])"
                                      :active="request()->routeIs('posts.index')">
                        {{ __('Post') }}
                    </x-nav-link-group>
                </div>


                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
