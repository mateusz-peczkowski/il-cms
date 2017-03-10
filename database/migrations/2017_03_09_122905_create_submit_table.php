<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubmitTable extends Migration {

	public function up()
	{
		Schema::create('submit', function(Blueprint $table) {
			$table->increments('id');
			$table->text('data');
			$table->string('ip', 255);
			$table->string('language', 10);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('submit');
	}
}