<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControlTable extends Migration {

	public function up()
	{
		Schema::create('control', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('label', 255);
			$table->string('type', 255);
			$table->string('default', 255)->nullable();
			$table->string('values', 255)->nullable();
			$table->tinyInteger('required')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('control');
	}
}