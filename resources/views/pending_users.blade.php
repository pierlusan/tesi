<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestione Utenti') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-4">Utenti in attesa di approvazione</h2>
                    <ul>
                        @foreach ($users as $user)
                            <li class="border-b border-gray-300 pb-2 px-4 hover:bg-gray-100 hover:rounded">
                                <div class="flex justify-between items-center mx-2 pt-2">
                                    <div>
                                        <span class="font-semibold">{{ $user->name }}</span><br>
                                        <span class="text-gray-600">{{ $user->email }}</span>
                                    </div>
                                    @if (!$user->approved)
                                        <form method="POST" action="{{ route('admin.approve_user', ['user' => $user]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Approva
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
