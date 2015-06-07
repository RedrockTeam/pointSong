<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        Schema::create('admin', function ($table) {
            $table->increments('id');
            $table->string('username', 32);
            $table->string('password', 32);
        });
        DB::table('admin')->insert(array(
            'username' => 'ygxg*',
            'password' => md5('ygxg*'),
        ));
    }
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('admin');

    }

}
