<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateControlTable extends Migration {

	public function up()
	{
		Schema::create('form_controls', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('label', 255);
			$table->string('type', 255);
			$table->string('default', 255)->nullable();
			$table->string('values', 255)->nullable();
			$table->boolean('required')->default(false);
            $table->integer('form_id')->unsigned();
            $table->enum('status', array('1', '2'))->default('1');
            $table->integer('who_updated')->unsigned()->nullable();
            $table->integer('order')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('form_controls');
	}
}