<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg" style="max-height: 85.5vh; overflow-y: auto;">
                <div class="p-6 backdrop-blur-3xl">
                    <h2 class="text-2xl text-stone-100 font-semibold mb-4">Utenti in attesa di approvazione</h2>
                    <ul>
                        @foreach ($users as $user)
                            <li class="border-b border-stone-500 pb-2 px-4 hover:bg-stone-700 transition ease-in-out duration-150">
                                <div class="flex justify-between items-center mx-2 pt-2">
                                    <div>
                                        <span class="text-stone-100 font-semibold">{{ $user->name }}</span><br>
                                        <span class="text-stone-400">{{ $user->email }}</span>
                                    </div>
                                    @if (!$user->approved)
                                        <form method="POST" action="{{ route('admin.approve_user', ['user' => $user]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-stone-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-stone-700 focus:bg-stone-700 active:bg-stone-900 focus:outline-none focus:ring-2 focus:ring-stone-800 focus:ring-offset-2 transition ease-in-out duration-150">
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
