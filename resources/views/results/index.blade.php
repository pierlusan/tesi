<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-300 p-6 overflow-hidden shadow-md sm:rounded-lg">

                @if(count($survey->SurveyResponses) != 0)
                    @foreach($survey->SurveyResponses as $result)
                        <div class="bg-stone-500 opacity-80 rounded-md shadow-md px-4 pb-4 pt-1 mt-4">

                            <div>DOMANDA: {{$result->question}}</div>
                            <div>RISPOSTA: {{$result->answer}}</div>

                        </div>
                    @endforeach
                @else
                    <div>
                        Il paziente non ha ancora riempito il questionario
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
