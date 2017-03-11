<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageModulesTable extends Migration {

	public function up()
	{
		Schema::create('con_page_modules', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->integer('module_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('con_page_modules');
	}
}