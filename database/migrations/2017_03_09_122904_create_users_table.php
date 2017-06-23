<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('email', 255)->unique();
			$table->string('password');
            $table->string('image')->nullable();
			$table->integer('role')->unsigned();
			$table->enum('status', array('1', '2', '3', '4'));
			$table->rememberToken('rememberToken');
            $table->integer('who_updated')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}