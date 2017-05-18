<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNodesTable extends Migration {

	public function up()
	{
		Schema::create('navigation_nodes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title', 255)->nullable();
			$table->integer('navigation_id')->unsigned();
			$table->integer('page_id')->unsigned();
			$table->integer('parent_id')->unsigned();
			$table->integer('order')->unsigned();
			$table->enum('status', array('1', '2', '3'));
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('navigation_nodes');
	}
}