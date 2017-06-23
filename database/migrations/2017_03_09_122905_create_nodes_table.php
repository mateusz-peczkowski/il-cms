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
			$table->integer('parent_id')->unsigned()->nullable();
            $table->integer('who_updated')->unsigned()->nullable();
            $table->string('locale', 64);
			$table->integer('order')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('navigation_nodes');
	}
}