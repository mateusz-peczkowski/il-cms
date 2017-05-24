<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionsTable extends Migration {

	public function up()
	{
		Schema::create('sections', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->string('title', 255);
			$table->string('header', 255);
			$table->string('view', 64);
            $table->integer('who_updated')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sections');
	}
}