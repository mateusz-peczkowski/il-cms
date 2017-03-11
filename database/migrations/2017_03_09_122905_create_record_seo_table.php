<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordSeoTable extends Migration {

	public function up()
	{
		Schema::create('con_record_seo', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('record_id')->unsigned();
			$table->integer('seo_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('con_record_seo');
	}
}