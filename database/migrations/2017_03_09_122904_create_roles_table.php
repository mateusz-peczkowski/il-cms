<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	public function up()
	{
		Schema::create('user_roles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('user_roles');
	}
}