<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

	public function up()
	{
		Schema::create('modules', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->text('structure');
			$table->string('module_name');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('modules');
	}
}