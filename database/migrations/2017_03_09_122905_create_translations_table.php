<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTranslationsTable extends Migration {

	public function up()
	{
		Schema::create('language_translations', function(Blueprint $table) {
			$table->increments('id');
			$table->string('key', 255);
            $table->string('value', 255);
            $table->string('locale', 64);
			$table->enum('status', array('1', '2', '3', '4'));
            $table->integer('who_updated')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('language_translations');
	}
}