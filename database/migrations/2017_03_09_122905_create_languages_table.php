<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 64);
			$table->string('slug', 10)->unique();
            $table->enum('is_default', array('0', '1'));
			$table->enum('status', array('1', '2', '3', '4'));
			$table->integer('order')->unsigned();
            $table->integer('who_updated')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('languages');
	}
}