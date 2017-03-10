<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediasTable extends Migration {

	public function up()
	{
		Schema::create('medias', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255)->nullable();
			$table->text('description')->nullable();
			$table->string('type', 255);
			$table->string('path', 255);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('medias');
	}
}