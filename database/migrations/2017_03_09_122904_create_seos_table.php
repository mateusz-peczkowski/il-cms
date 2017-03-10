<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeosTable extends Migration {

	public function up()
	{
		Schema::create('seos', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 128)->nullable();
			$table->string('keys', 255)->nullable();
			$table->string('description', 255)->nullable();
			$table->text('page_head')->nullable();
			$table->text('page_footer')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('seos');
	}
}