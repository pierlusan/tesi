<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    public function create(Survey $survey)
    {
        return view('question.create',compact('survey'));

    }

    public function store(Survey $survey)
    {

        //dd(request()->all());
        $data = request();
        //dd($data);



        //questo va bene sia se metto la domanda a risposta aperta sia se metto quella a risposte multiple se aggiungo almeno una domanda ma se ne metto zero da errore

        if($data['type'] == 'multiple_choice'){
            $question = $survey->questions()->create(['question' => $data['question'],'type'=>$data['type']]);
            $question->answers()->createMany($data['answers']);
        }elseif($data['type'] == 'question_with_image'){
            $fileName = time().$data->file('image')->getClientOriginalName();
            $path = $data->file('image')->storeAs('images',$fileName,'public');
            $foto = '/storage/'.$path;
            $question = $survey->questions()->create(['question' => $data['question'],'type'=>$data['type'],'immagine' => $foto]);
        }elseif ($data['type'] == 'open-ended'){
            $question = $survey->questions()->create(['question' => $data['question'],'type'=>$data['type']]);
        }


        return redirect('/survey/' . $survey->id);

    }

    public function delete(Survey $survey, Question $question)
    {

        //$question->responses()->delete();
        $question->answers()->delete();

        $question->delete();

        return redirect($survey->link());
    }
}
