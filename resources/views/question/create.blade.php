<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="backdrop-blur-300 p-6 overflow-hidden shadow-md sm:rounded-lg">

                <form id="dynamicForm" action="/survey/{{$survey->id}}/questions/create" method="post"  enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">

                        <select name="type" id="type" onchange="toggleAnswerFields()">
                            <option value="multiple_choice">Risposta Multipla</option>
                            <option value="open-ended">Risposta Aperta</option>
                            <option value="question_with_image">Domanda con immagine</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="question" class="block text-stone-100">Domanda<span class="font-bold text-base text-red-600">*</span></label>
                        <x-text-input placeholder="Domanda" type="text" name="question" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 w-full shadow-md" id="question" required></x-text-input>
                    </div>




                    <div id="image" class="mb-4">
                        <label for="image">Carica un'immagine</label>
                        <input type="file" name="image" accept="image/*">
                    </div>

                    <div id="risposta_multipla">
                        <div id="dynamicFields"></div>
                        <x-primary-button type="button" onclick="addQuestion()">Aggiungi</x-primary-button>
                    </div>


                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button type="submit">Salva</x-primary-button>
                    </div>
                </form>

                <script>
                    function toggleAnswerFields() {
                        var questionType = document.getElementById('type').value;
                        var answerFields = document.querySelectorAll('[name^="answers["]');
                        var image = document.getElementById('image')
                        var risposta_multipla = document.getElementById('risposta_multipla')


                        if(questionType === 'multiple_choice'){
                            image.style.display = "none"
                            risposta_multipla.style.display = 'block'
                        }else if(questionType === 'open-ended'){
                            risposta_multipla.style.display = "none"
                            image.style.display = "none"
                        }else if(questionType === 'question_with_image'){
                            risposta_multipla.style.display = "none"
                            image.style.display = 'block'
                        }
                        else {
                            image.style.display = "block"; // o "initial" a seconda delle tue esigenze
                        }

                    }

                    function addQuestion() {
                        var dynamicFields = document.getElementById('dynamicFields');
                        var newQuestion = document.createElement('div');
                        newQuestion.className = 'mb-4';

                        newQuestion.innerHTML =
                            '<div class="flex items-center relative">' +
                            '<input placeholder="Opzione" type="text" name="answers[][answer]" class="block bg-stone-300 border-stone-600 focus:border-stone-700 focus:ring-stone-700 w-full pr-8 shadow-md">' +
                            '<span style="cursor: pointer; position: absolute; right: 15px; top: 50%; transform: translateY(-50%);" onclick="removeQuestion(this)">X</span>' +
                            '</div>';

                        dynamicFields.appendChild(newQuestion);
                    }
                    function removeQuestion(buttonElement) {

                        var questionContainer = buttonElement.parentNode.parentNode;


                        var dynamicFields = document.getElementById('dynamicFields');


                        dynamicFields.removeChild(questionContainer);
                    }

                    window.onload = function() {
                        toggleAnswerFields();
                    };
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
