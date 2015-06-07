<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Music',function($table){
            $table->increments('id');
            $table->string('music',50);
            $table->string('recieve_name',20);
            $table->string('head_image');
            $table->text('content');
            $table->string('send_name');
            $table->integer('goods')->lenth(20)->unsigned();
            $table->tinyInteger('is_sayname')->lenth(2)->unsigned();
            $table->tinyInteger('status')->lenth(2)->unsigned();
            $table->integer('time');
            $table->integer('operate_time');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("Music");
    }

}
