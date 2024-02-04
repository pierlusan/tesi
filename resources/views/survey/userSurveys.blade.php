<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-3xl overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 backdrop-blur-3xl">
                    @if($surveys)
                        <ul class="list-group">
                            @foreach($surveys as $survey)
                                <li>
                                    <div class="bg-stone-500 opacity-80 rounded-md shadow-md px-4 pb-4 pt-1 mt-4">
                                        <div class="mb-1">{{ $survey->title }}</div>
                                        <div class="text-stone-300 text-sm">{{ $survey->description }}</div>
                                        <div
                                            class="text-stone-400 text-xs mt-2">{{date('d/m/y H:m:s',strtotime($survey->created_at))}}</div>

                                        <div class="flex items-center justify-end mt-4">
                                            <form action="/survey/{{$survey->id}}" method="GET">
                                                <x-primary-button>
                                                    Enter
                                                </x-primary-button>
                                            </form>
                                            <form action="/survey/{{$survey->id}} " method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <x-danger-button>
                                                    ELIMINA
                                                </x-danger-button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
