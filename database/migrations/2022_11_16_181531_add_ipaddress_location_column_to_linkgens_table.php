<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpaddressLocationColumnToLinkgensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link_gens', function (Blueprint $table) {
            $table->string('ipaddress')->nullable();
            $table->string('location')->nullable();
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
            $table->string('ipaddress')->nullable();
            $table->string('location')->nullable();
        });
    }
}
