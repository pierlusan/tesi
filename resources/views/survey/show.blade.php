<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-300 p-6 overflow-hidden shadow-md sm:rounded-lg">
                <div class="text-2xl text-stone-100 font-semibold">Titolo: {{$survey->title}}</div>
                <br>
                <div class="text-2xl text-stone-100 font-semibold">{{$survey->description}}</div>
                <br>
                <div class="">{{date('d/m/y H:m:s',strtotime($survey->created_at))}}</div>
                @if (!Auth::user()->isAdmin())
                <form action="/survey/take/{{$survey->id.'-'.Str::slug($survey->title)}}" method="GET">
                    <x-primary-button>
                        Compila il questionario
                    </x-primary-button>
                </form>
                @endif


                    <hr>
                    @foreach($survey->questions as $question)
                        <div class="bg-stone-500 opacity-80 rounded-md shadow-md px-4 pb-4 pt-1 mt-4">
                            <div>{{$question->question}}</div>

                            <div>
                                <ul class="list-group">
                                    @if(sizeof($question->answers) == 0)
                                        <div class="text-danger">Nessuna opzione inserita</div>
                                    @else
                                        @foreach($question->answers as $answer)
                                            <li class=" list-group-item">
                                                {{$answer->answer}}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            @if (Auth::user()->isAdmin())
                            <div class="card-footer">
                                <form action="/survey/{{ $survey->id }}/questions/{{ $question->id }}" method="POST">
                                    @method('DELETE')
                                    @csrf

                                    <x-danger-button type="submit">
                                        DELETE
                                    </x-danger-button>

                                </form>
                            </div>
                            @endif
                        </div>
                    @endforeach
                <br>
                    <hr>
                <br>
                @if (Auth::user()->isAdmin())
                    <form action="/survey/{{$survey->id}}/questions/create" method="GET">
                        <x-primary-button>
                            Aggiungi domanda
                        </x-primary-button>
                    </form>

                @endif
            </div>


        </div>
    </div>
</x-app-layout>
