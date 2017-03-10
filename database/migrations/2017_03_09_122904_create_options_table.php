<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionsTable extends Migration {

	public function up()
	{
		Schema::create('options', function(Blueprint $table) {
			$table->increments('id');
			$table->string('type', 255);
			$table->string('key', 64);
			$table->text('value');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('options');
	}
}