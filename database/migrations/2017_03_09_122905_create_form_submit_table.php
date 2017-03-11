<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormSubmitTable extends Migration {

	public function up()
	{
		Schema::create('con_form_submit', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('form_id')->unsigned();
			$table->integer('submit_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('con_form_submit');
	}
}