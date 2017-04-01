<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('nodes', function(Blueprint $table) {
			$table->foreign('navigation_id')->references('id')->on('navigations')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('nodes', function(Blueprint $table) {
			$table->foreign('page_id')->references('id')->on('pages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('role')->references('id')->on('roles')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('redirects', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
	}

	public function down()
	{
		Schema::table('nodes', function(Blueprint $table) {
			$table->dropForeign('nodes_navigation_id_foreign');
		});
		Schema::table('nodes', function(Blueprint $table) {
			$table->dropForeign('nodes_page_id_foreign');
		});
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_role_foreign');
        });
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_who_updated_foreign');
        });
        Schema::table('redirects', function(Blueprint $table) {
            $table->dropForeign('redirects_who_updated_foreign');
        });
	}
}