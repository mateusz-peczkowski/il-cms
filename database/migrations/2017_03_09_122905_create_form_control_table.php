<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormControlTable extends Migration {

	public function up()
	{
		Schema::create('con_form_control', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->integer('control_id')->unsigned();
			$table->integer('order')->unsigned();
			$table->enum('status', array('1', '2', '3'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('con_form_control');
	}
}