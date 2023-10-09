<div class="bg-gray-500 pl-7 pr-8 pb-1 pt-3 border-b border-gray-300 flex justify-left space-x-4">
    <x-nav-link-group :href="route('groups.show', ['group' => $group])"
                      :active="request()->routeIs('groups.show')">
        {{ __('Home') }}
    </x-nav-link-group>
    <x-nav-link-group :href="route('posts.index', ['group' => $group])"
                      :active="request()->routeIs('posts.index')">
        {{ __('Post') }}
        <span class="inline-block bg-gray-300 text-gray-500 rounded px-1.5 -py-1 ml-1.5 text-xs">
            {{ $group->posts()->count() }}
        </span>
    </x-nav-link-group>
</div>
