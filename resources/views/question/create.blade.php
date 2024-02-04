<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-300 p-6 overflow-hidden shadow-md sm:rounded-lg">

                <form id="dynamicForm" action="/survey/{{$survey->id}}/questions/create" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="question" class="block text-stone-100">Domanda<span class="font-bold text-base text-red-600">*</span></label>
                        <x-text-input type="text" name="question" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 w-full shadow-md" id="question" required></x-text-input>
                    </div>

                    <div class="mb-4">
                        <label for="type">Tipo Domanda</label>
                        <select name="type" id="type" onchange="toggleAnswerFields()">
                            <option value="multiple_choice">Risposta Multipla</option>
                            <option value="open-ended">Risposta Aperta</option>
                            <option value="question_with_image">Domanda con immagine</option>
                        </select>
                    </div>

                    <div id="image" class="mb-4">
                        <label for="image">Carica un'immagine</label>
                        <input type="file" name="image" accept="image/*">
                    </div>

                    <div id="dynamicFields"></div>

                    <button type="button" onclick="addQuestion()">Aggiungi</button>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button type="submit">Salva</x-primary-button>
                    </div>
                </form>

                <script>
                    function toggleAnswerFields() {
                        var questionType = document.getElementById('questionType').value;
                        var answerFields = document.querySelectorAll('[name^="answers["]');

                        answerFields.forEach(function (field) {
                            field.style.display = (questionType === 'multiple_choice') ? 'block' : 'none';
                        });
                    }

                    function addQuestion() {
                        var dynamicFields = document.getElementById('dynamicFields');
                        var newQuestion = document.createElement('div');
                        newQuestion.innerHTML = '<div class="mb-4">' +
                            '<label for="newQuestion">Nuova Domanda</label>' +
                            '<input type="text" name="answers[][answer]" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 w-full shadow-md">' +
                            '</div>';

                        dynamicFields.appendChild(newQuestion);
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
