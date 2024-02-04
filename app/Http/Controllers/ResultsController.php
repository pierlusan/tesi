<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    //
    public function take(Survey $survey)
    {
        //$surveyResponce = SurveyResponse::where();
        return view('results.index');
    }
}
