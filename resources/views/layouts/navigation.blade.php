<nav x-data="{ open: false }" class="bg-stone-500 border-b border-stone-600 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 -mr-2 ml-2 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src={{asset('logo-white-sm.png')}} alt="Logo" class="block h-12 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (Auth::user()->approved)
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Calendario') }}
                        </x-nav-link>
                        <x-nav-link :href="route('groups.index')" :active="request()->routeIs('groups.index')">
                            {{ __('Gruppi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('survey.index')" :active="request()->routeIs('survey.index')">
                            Questionari
                        </x-nav-link>
                        <x-nav-link :href="route('single_events.index')" :active="request()->routeIs('single_events.index')">
                            {{ __('Eventi Personali') }}
                            <span class="inline-block bg-stone-700 text-white rounded px-1.5 ml-1.5" style="font-size: 0.65em">
                                @if(auth()->user()->isAdmin())
                                    {{ \App\Models\SingleEvent::all()->whereIn('status', [App\Enum\EventStatus::PLANNED, App\Enum\EventStatus::ACTIVE])->count() }}
                                @else
                                    {{ auth()->user()->singleEvents()->whereIn('status', [App\Enum\EventStatus::PLANNED, App\Enum\EventStatus::ACTIVE])->count() }}
                                @endif
                            </span>
                        </x-nav-link>
                    @endif
                    @if (Auth::user()->is_admin)
                        <x-nav-link :href="route('admin.pending_users')" :active="request()->routeIs('admin.pending_users')">
                            {{ __('Gestione Utenti') }}
                            <span class="inline-block bg-stone-700 text-white rounded px-1.5 ml-1.5" style="font-size: 0.65em">
                                {{ $pendingUsersCount }}
                            </span>
                        </x-nav-link>
                    @endif
                </div>
            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-stone-100 hover:text-stone-50 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profilo') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-stone-200 hover:text-stone-100 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden ">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-stone-200">
            <div class="px-4">
                <div class="font-medium text-base text-stone-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-stone-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 ">
                <x-responsive-nav-link :href="route('profile.edit')" >
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
