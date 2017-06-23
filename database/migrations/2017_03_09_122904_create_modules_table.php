<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

	public function up()
	{
		Schema::create('modules', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255);
            $table->string('slug');
            $table->text('structure')->nullable();
            $table->integer('order')->unsigned();
            $table->integer('who_updated')->unsigned()->nullable();
            $table->boolean('has_details')->default(0);
            $table->string('order_records')->default('created_at');
            $table->enum('order_records_type', array('asc', 'desc'))->default('desc');
            $table->enum('status', array('1', '2', '3', '4'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('modules');
	}
}