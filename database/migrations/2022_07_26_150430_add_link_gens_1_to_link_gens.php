<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkGens1ToLinkGens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link_gens', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable()->after('audio_status');
            $table->string('email')->nullable()->after('audio_status');
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
            //
        });
    }
}
