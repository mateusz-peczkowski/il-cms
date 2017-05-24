<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageOptionsTable extends Migration {

	public function up()
	{
		Schema::create('page_options', function(Blueprint $table) {
			$table->increments('id');
            $table->string('key', 255);
            $table->string('slug', 255);
            $table->enum('type', array('text', 'textarea', 'select', 'checkbox'));
            $table->text('values')->nullable();
            $table->text('value')->nullable();
            $table->integer('who_updated')->unsigned()->nullable();
            $table->integer('page_id')->unsigned();
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('page_options');
	}
}
