<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	public function up()
	{
		Schema::create('pages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('url', 255);
			$table->integer('order')->unsigned();
			$table->string('tag', 64)->unique()->nullable();
			$table->string('controller', 64)->nullable();
			$table->string('view', 64)->nullable();
			$table->enum('status', array('1', '2', '3'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('pages');
	}
}