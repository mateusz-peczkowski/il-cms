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
						->onUpdate('cascade');
		});
		Schema::table('nodes', function(Blueprint $table) {
			$table->foreign('page_id')->references('id')->on('pages')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('role')->references('id')->on('roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('redirects', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('translations', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('languages', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('options', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('forms', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('form_controls', function(Blueprint $table) {
            $table->foreign('form_id')->references('id')->on('forms')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('form_controls', function(Blueprint $table) {
            $table->foreign('who_updated')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
        Schema::table('submit', function(Blueprint $table) {
            $table->foreign('form_id')->references('id')->on('forms')
                ->onDelete('restrict')
                ->onUpdate('cascade');
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
        Schema::table('translations', function(Blueprint $table) {
            $table->dropForeign('translations_who_updated_foreign');
        });
        Schema::table('languages', function(Blueprint $table) {
            $table->dropForeign('languages_who_updated_foreign');
        });
        Schema::table('options', function(Blueprint $table) {
            $table->dropForeign('options_who_updated_foreign');
        });
        Schema::table('forms', function(Blueprint $table) {
            $table->dropForeign('forms_who_updated_foreign');
        });
        Schema::table('form_controls', function(Blueprint $table) {
            $table->dropForeign('form_controls_who_updated_foreign');
        });
        Schema::table('form_controls', function(Blueprint $table) {
            $table->dropForeign('form_controls_form_id_foreign');
        });
        Schema::table('submit', function(Blueprint $table) {
            $table->dropForeign('submit_form_id_foreign');
        });
	}
}