<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 64);
			$table->string('slug', 10);
			$table->tinyInteger('is_default')->unsigned();
			$table->enum('status', array('1', '2', '3'));
			$table->integer('order')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('languages');
	}
}