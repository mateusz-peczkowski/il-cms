<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRedirectsTable extends Migration {

	public function up()
	{
		Schema::create('redirects', function(Blueprint $table) {
			$table->increments('id');
			$table->string('from', 255)->unique();
			$table->string('to', 255);
			$table->enum('status', array('1', '2', '3', '4'));
            $table->integer('who_updated')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('redirects');
	}
}