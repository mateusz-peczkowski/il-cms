<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionMediaTable extends Migration {

	public function up()
	{
		Schema::create('con_section_media', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('section_id')->unsigned();
            $table->integer('media_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('con_section_media');
	}
}