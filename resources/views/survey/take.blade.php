<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-300 p-6 overflow-hidden shadow-md sm:rounded-lg">
                <h1> Compila questionario: {{$survey->title}}</h1>
                <form action="/survey/take/{{$survey->id.'-'.Str::slug($survey->title)}}" method="post">

                    @csrf

                    @foreach($survey->questions as $key=>$question)
                        <div>
                            <div>{{$key+1}} : {{$question->question}}></div>

                            <div>
                                <ul>
                                    @if(sizeof($question->answers) == 0)
                                        <div>Nessuna opzione inserita</div>
                                    @else
                                        @foreach($question->answers as $answer)
                                            <lable for="answer_{{$answer->id}}">
                                                <li>

                                                    <input type="radio"
                                                           name="responses[{{ $key }}][answer_id]"
                                                           id="answer_{{$answer->id}}"
                                                           value="{{$answer->id}}"
                                                           {{ (old('responses.'.$key.'.answer-id')== $answer->id) ? 'checked' : '' }}
                                                    >
                                                    {{$answer->answer}}
                                                    <input type="hidden" name="responses[{{$key}}][question_id]" value="{{ $question->id }}">
                                                </li>
                                            </lable>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="-bottom-0">Salva</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
