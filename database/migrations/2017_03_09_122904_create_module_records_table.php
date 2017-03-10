<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuleRecordsTable extends Migration {

	public function up()
	{
		Schema::create('module_records', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->string('title', 255);
			$table->text('content');
			$table->integer('order')->unsigned();
			$table->string('url', 255)->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('module_records');
	}
}