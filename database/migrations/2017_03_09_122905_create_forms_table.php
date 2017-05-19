<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormsTable extends Migration {

	public function up()
	{
		Schema::create('forms', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->string('tag', 64);
			$table->enum('type', array('contact', 'newsletter'));
			$table->text('description')->nullable();
			$table->string('sender_name', 255);
			$table->string('sender_email', 255);
			$table->boolean('confirmation')->default(true);
			$table->enum('status', array('1', '2', '3'))->default('1');
			$table->string('locale', 64);
            $table->integer('who_updated')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('forms');
	}
}