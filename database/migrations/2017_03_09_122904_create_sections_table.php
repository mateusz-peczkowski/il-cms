<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionsTable extends Migration {

	public function up()
	{
		Schema::create('sections', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
			$table->string('header', 255);
			$table->text('content');
			$table->string('view', 64);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sections');
	}
}