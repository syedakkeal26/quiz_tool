<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkGensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_gens', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('dept_id');
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->enum('answer', ['1','0'])->comment('1 - active, 0 - not active');
            $table->string('slug')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->integer('total_mark')->nullable();
            $table->enum('audio_status', ['disable', 'enable']);
            $table->timestamps();
            $table->foreign('dept_id')->references('id')->on('quiz_mains')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('participators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('link_gens', function (Blueprint $table) {
            $table->dropForeign('link_gens_dept_id_foreign');
            $table->dropColumn('dept_id');
            $table->dropForeign('link_gens_participant_id_foreign');
            $table->dropColumn('participant_id');
        });
        Schema::dropIfExists('link_gens');
    }
}
