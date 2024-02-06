<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-300 p-6 overflow-hidden shadow-md sm:rounded-lg">
                <h1> Compila questionario: {{$survey->title}}</h1>
                <form action="/survey/take/{{$survey->id.'-'.Str::slug($survey->title)}}" method="post">

                    @csrf

                    @foreach($survey->questions as $key=>$question)
                        <div >
                            <div>{{$key+1}} : {{$question->question}}</div>

                            <div>
                                <ul>
                                    @if($question->type == 'question_with_image')
                                        <img src="{{ asset($question->immagine) }}">
                                        <label for="open_ended_response_{{$key}}">
                                            <textarea name="responses[{{$key}}][answer]"
                                                      id="question_with_image_{{$key}}">{{ old('responses.'.$key.'.open_ended_response') }}</textarea>
                                            <input type="hidden" name="responses[{{$key}}][question]"
                                                   value="{{ $question->question }}">
                                            <input type="hidden" name="responses[{{$key}}][image]"
                                                   value="{{ $question->immagine }}">
                                        </label>
                                    @endif

                                    @if($question->type == 'multiple_choice')
                                        @foreach($question->answers as $answer)
                                            <label for="answer_{{$answer->id}}">
                                                <li>
                                                    <input type="radio"
                                                           name="responses[{{ $key }}][answer]"
                                                           id="answer_{{$answer->answer}}"
                                                           value="{{$answer->answer}}"
                                                        {{ (old('responses.'.$key.'.answer_answer')== $answer->answer) ? 'checked' : '' }}
                                                    >
                                                    {{$answer->answer}}
                                                    <input type="hidden" name="responses[{{$key}}][question]"
                                                           value="{{ $question->question }}">
                                                </li>
                                            </label>
                                        @endforeach
                                    @elseif($question->type == 'open-ended')
                                        <label for="open_ended_response_{{$key}}">
                                            <textarea name="responses[{{$key}}][answer]"
                                                      id="open_ended_response_{{$key}}">{{ old('responses.'.$key.'.open_ended_response') }}</textarea>
                                            <input type="hidden" name="responses[{{$key}}][question]"
                                                   value="{{ $question->question }}">
                                        </label>
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
