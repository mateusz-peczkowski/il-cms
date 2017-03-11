<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageSeoTable extends Migration {

	public function up()
	{
		Schema::create('con_page_seo', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->integer('seo_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('con_page_seo');
	}
}