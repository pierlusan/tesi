<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    public $guarded = [];
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function surveyCompilations()
    {
        return $this->hasMany(SurveyCompilation::class);
    }

    public function link()
    {
        return '/survey/' . $this->id;
    }

    public function SurveyResponses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
