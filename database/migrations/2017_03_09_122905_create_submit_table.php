<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubmitTable extends Migration {

	public function up()
	{
		Schema::create('form_submits', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('form_id')->unsigned()->nullable();
            $table->text('data');
			$table->string('ip', 255);
			$table->string('language', 10);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('form_submits');
	}
}