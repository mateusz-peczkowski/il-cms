<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuleRecordsTable extends Migration {

	public function up()
	{
		Schema::create('module_records', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
            $table->string('slug')->nullable();
            $table->text('data')->nullable();
            $table->text('section_data')->nullable();
            $table->integer('module_id')->unsigned();
            $table->integer('order')->unsigned();
            $table->enum('status', array('1', '2'));
            $table->integer('who_updated')->unsigned()->nullable();
            $table->string('locale', 64);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('module_records');
	}
}