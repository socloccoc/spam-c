<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrontabSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crontab_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('cookie');
            $table->integer('time_once');
            $table->integer('time_request');
            $table->integer('card_number');
            $table->integer('status')->comment('1: ON, 2:OFF');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crontab_settings');
    }
}
