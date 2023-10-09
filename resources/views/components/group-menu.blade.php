<div class="bg-gray-500 pl-7 pr-8 pb-1 pt-3 border-b border-gray-300 flex justify-left space-x-4">
    <x-nav-link-group :href="route('groups.show', ['group' => $group])"
                      :active="request()->routeIs('groups.show')">
        {{ __('Home') }}
    </x-nav-link-group>
    <x-nav-link-group :href="route('posts.index', ['group' => $group])"
                      :active="request()->routeIs('posts.index')">
        {{ __('Post') }}
    </x-nav-link-group>
</div>
