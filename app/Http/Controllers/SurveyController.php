<?php

namespace App\Http\Controllers;
use App\Events\NoticeEvent;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Http\Request;

class SurveyController extends Controller
{


    public function index()
    {
        $users = User::where('approved', true)->where('is_admin',false)->get();;

        $user = User::where('id',auth()->user()->id)->first();
        //dd($user);
        if($user->isAdmin()){
            $surveys = Survey::where('admin_id',auth()->user()->id)->get();
        }else{
            $surveys = Survey::where('user_id',auth()->user()->id)->get();
        }




        return view('survey.index',compact('surveys'),['users'=> $users]);
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
        $survey->completed = false;
        $survey->save();

        $messaggio = ['utente'=> $survey->user_id, 'messaggio'=>'Hai un nuovo questionario'];
        //dd($messaggio);
        NoticeEvent::dispatch($messaggio);

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
        $data = request();




        foreach ($data['responses'] as $response) {
            $surveyResponse = new SurveyResponse();
            $surveyResponse->question = $response['question'];
            $surveyResponse->answer = $response['answer'];
            $surveyResponse->survey_id = $survey->id;
            $surveyResponse->user_id = auth()->user()->id;
            $surveyResponse->save();
            if(array_key_exists('image',$response)){
                $surveyResponse->immagine = $response['image'];
                $surveyResponse->save();
            }
        }
        $user = User::where('id', auth()->user()->id)->first();
        //dd($user);
        $messaggio = ['utente'=> '2' , 'messaggio'=>'L\'utente '.$user->name.' ha completato un questionario'];
        //dd($messaggio);

        NoticeEvent::dispatch($messaggio);
        $survey->completed = true;
        $survey->save();


        return redirect('/survey/' . $survey->id);




    }

    public function userSurveys(User $user)
    {
        $surveys = Survey::where('user_id',$user->id)->get();
        return view('survey.userSurveys',compact('user'),['surveys'=>$surveys]);
    }

    public function delete(Survey $survey)
    {
        $survey->SurveyResponses()->delete();
        $survey->questions()->delete();
        $survey->delete();
        return redirect()->back();
    }


}
