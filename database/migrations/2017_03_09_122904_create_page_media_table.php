<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageMediaTable extends Migration {

	public function up()
	{
		Schema::create('page_media', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->integer('media_id')->unsigned();
			$table->integer('order')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('page_media');
	}
}