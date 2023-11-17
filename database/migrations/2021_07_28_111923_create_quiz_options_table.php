<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->string('option');
            $table->enum('answer', ['0','1'])->comment('0 - not correct, 1 - correct');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();
            $table->foreign('question_id')->references('id')->on('quiz_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_options', function (Blueprint $table) {
            $table->dropForeign('quiz_options_question_id_foreign');
            $table->dropColumn('question_id');
        });
        Schema::dropIfExists('quiz_options');
    }
}
