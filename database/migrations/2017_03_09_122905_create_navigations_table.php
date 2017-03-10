<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNavigationsTable extends Migration {

	public function up()
	{
		Schema::create('navigations', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->string('tag', 64)->unique();
			$table->integer('order')->unsigned();
			$table->enum('status', array('1', '2', '3'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('navigations');
	}
}