<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageOptionTable extends Migration {

	public function up()
	{
		Schema::create('con_page_option', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->integer('option_id')->unsigned();
			$table->integer('order')->unsigned();
			$table->enum('status', array('1', '2', '3'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('con_page_option');
	}
}