<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeosTable extends Migration {

	public function up()
	{
		Schema::create('seos', function(Blueprint $table) {
			$table->increments('id');
            $table->string('model', 64);
            $table->integer('model_id')->unsigned();
            $table->string('meta_title', 128)->nullable();
			$table->string('meta_keys', 255)->nullable();
			$table->string('meta_description', 255)->nullable();
			$table->text('page_head')->nullable();
            $table->text('page_footer')->nullable();
            $table->integer('who_updated')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('seos');
	}
}