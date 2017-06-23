<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNavigationsTable extends Migration {

	public function up()
	{
		Schema::create('navigations', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
            $table->string('slug', 64)->unique();
			$table->string('tag', 64)->unique();
			$table->integer('order')->unsigned();
            $table->integer('who_updated')->unsigned()->nullable();
			$table->enum('status', array('1', '2', '3', '4'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('navigations');
	}
}