<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-4">Utenti in attesa di approvazione</h2>
                    <ul>
                        @foreach ($users as $user)
                            <li class="mb-2 border-b border-gray-300 pb-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $user->name }}</span><br>
                                        <span class="text-gray-600">{{ $user->email }}</span>
                                    </div>
                                    @if (!$user->approved)
                                        <form method="POST" action="{{ route('admin.approve_user', ['user' => $user]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-gray-600 hover:bg-gray-900 text-white font-semibold py-1 px-2 rounded shadow-md text-sm uppercase">
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
