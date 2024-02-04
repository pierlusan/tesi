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


        $data = request()->validate([
            'question' => 'required',
            'answers.*.answer' => 'required'
        ]);

        //dd(request()->all());

        $question = $survey->questions()->create(['question' => $data['question']]);
        $question->answers()->createMany($data['answers']);

        return redirect('/survey/' . $survey->id);
    }

    public function delete(Survey $survey, Question $question)
    {

        $question->responses()->delete();
        $question->answers()->delete();

        $question->delete();

        return redirect($survey->link());
    }
}
