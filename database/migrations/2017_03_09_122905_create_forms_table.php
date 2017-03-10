<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormsTable extends Migration {

	public function up()
	{
		Schema::create('forms', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->string('tag', 64)->unique()->nullable();
			$table->enum('type', array('contact', 'newsletter'));
			$table->text('description')->nullable();
			$table->string('sender_name', 255);
			$table->string('sender_email', 255);
			$table->tinyInteger('confirmation')->unsigned();
			$table->string('notification_email', 255)->nullable();
			$table->enum('status', array('1', '2', '3'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('forms');
	}
}