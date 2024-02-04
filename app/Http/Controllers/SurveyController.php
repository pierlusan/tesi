<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;

class SurveyController extends Controller
{


    public function index()
    {

        $user = User::where('id',auth()->user()->id)->first();
        //dd($user);
        if($user->isAdmin()){
            $surveys = Survey::where('admin_id',auth()->user()->id)->get();
        }else{
            $surveys = Survey::where('user_id',auth()->user()->id)->get();
        }




        return view('survey.index',compact('surveys'));
    }

    public function create()
    {
        $users = User::where('approved', true)
            ->where('is_admin', false)
            ->orderBy('name', 'asc')
            ->get();
        return view('survey.create',['users'=> $users]);
    }
    public function store()
    {
        //dd(request()->all());



        $data = request();

        $survey = new Survey();

        $survey->title = $data['title'];
        $survey->description = $data['description'];
        $survey->user_id = $data['user_id'];
        $survey->admin_id = auth()->user()->id;
        $survey->save();

        //$survey = auth()->user()->surveys()->create($data);
        return redirect('/survey/' . $survey->id);




    }

    public function show(Survey $survey)
    {
        return view('survey.show', compact('survey'));
    }


    public function take(Survey $survey,$slug)
    {
        return view('survey.take',compact('survey'));
    }

    public function takeStore(Survey $survey)
    {
        //dd(request()->all());
        $data = request()->validate([
            'responses.*.question_id' => 'required',
            'responses.*.answer_id' => 'required'
        ]);


        $surveyCompilation = $survey->surveyCompilations()->create(['user_id'=> auth()->user()->id]);
        $surveyCompilation->responses()->createMany($data['responses']);
        return redirect('/survey/' . $survey->id);
    }


}
