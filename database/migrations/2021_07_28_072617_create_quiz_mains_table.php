<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_mains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->integer('max_number_questions');
            $table->integer('max_score');
            $table->unsignedBigInteger('category_id');
            $table->enum('level', ['Common','Beginner','Intermediate','Expert']);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quiz_mains', function (Blueprint $table) {
            $table->dropForeign('quiz_mains_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('quiz_mains');
    }
}
