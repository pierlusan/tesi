<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();

            /*
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');

            $table->bigInteger('answer_id')->unsigned();
            $table->foreign('answer_id')->references('id')->on('answers');
            */

            $table->string('answer');
            $table->string('question');

            $table->bigInteger('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');;


            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
