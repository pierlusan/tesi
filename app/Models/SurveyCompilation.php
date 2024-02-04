<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyCompilation extends Model
{
    use HasFactory;

    public $guarded = [];
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }


    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
