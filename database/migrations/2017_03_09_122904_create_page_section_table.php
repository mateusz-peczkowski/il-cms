<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageSectionTable extends Migration {

	public function up()
	{
		Schema::create('page_section', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->integer('section_id')->unsigned();
			$table->timestamps();
			$table->integer('order')->unsigned();
			$table->enum('status', array('1', '2', '3'));
		});
	}

	public function down()
	{
		Schema::drop('page_section');
	}
}