<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('score');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('quiz_id');
            $table->timestamps();
            $table->foreign('quiz_id')->references('id')->on('quiz_mains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropForeign('quiz_questions_quiz_id_foreign');
            $table->dropColumn('quiz_id');
        });
        Schema::dropIfExists('quiz_questions');
    }
}
