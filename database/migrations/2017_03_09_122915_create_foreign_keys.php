<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('con_page_seo', function(Blueprint $table) {
			$table->foreign('page_id')->references('id')->on('pages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_page_seo', function(Blueprint $table) {
			$table->foreign('seo_id')->references('id')->on('seos')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_page_option', function(Blueprint $table) {
			$table->foreign('page_id')->references('id')->on('pages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_page_option', function(Blueprint $table) {
			$table->foreign('option_id')->references('id')->on('options')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
        Schema::table('con_page_section', function(Blueprint $table) {
            $table->foreign('page_id')->references('id')->on('pages')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('con_page_section', function(Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('con_section_media', function(Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('con_section_media', function(Blueprint $table) {
            $table->foreign('media_id')->references('id')->on('medias')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
		Schema::table('con_page_media', function(Blueprint $table) {
			$table->foreign('page_id')->references('id')->on('pages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_page_media', function(Blueprint $table) {
			$table->foreign('media_id')->references('id')->on('medias')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_page_modules', function(Blueprint $table) {
			$table->foreign('page_id')->references('id')->on('pages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_page_modules', function(Blueprint $table) {
			$table->foreign('module_id')->references('id')->on('modules')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_module_records', function(Blueprint $table) {
			$table->foreign('module_id')->references('id')->on('modules')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_section', function(Blueprint $table) {
			$table->foreign('record_id')->references('id')->on('con_module_records')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_section', function(Blueprint $table) {
			$table->foreign('section_id')->references('id')->on('sections')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_media', function(Blueprint $table) {
			$table->foreign('record_id')->references('id')->on('con_module_records')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_media', function(Blueprint $table) {
			$table->foreign('media_id')->references('id')->on('medias')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_option', function(Blueprint $table) {
			$table->foreign('record_id')->references('id')->on('con_module_records')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_option', function(Blueprint $table) {
			$table->foreign('option_id')->references('id')->on('options')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_seo', function(Blueprint $table) {
			$table->foreign('record_id')->references('id')->on('con_module_records')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_record_seo', function(Blueprint $table) {
			$table->foreign('seo_id')->references('id')->on('seos')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
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
		Schema::table('con_form_submit', function(Blueprint $table) {
			$table->foreign('form_id')->references('id')->on('forms')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_form_submit', function(Blueprint $table) {
			$table->foreign('submit_id')->references('id')->on('submit')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('con_form_control', function(Blueprint $table) {
			$table->foreign('form_id')->references('id')->on('forms')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
        Schema::table('con_form_control', function(Blueprint $table) {
            $table->foreign('control_id')->references('id')->on('control')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('role')->references('id')->on('roles')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
	}

	public function down()
	{
		Schema::table('con_page_seo', function(Blueprint $table) {
			$table->dropForeign('con_page_seo_page_id_foreign');
		});
		Schema::table('con_page_seo', function(Blueprint $table) {
			$table->dropForeign('con_page_seo_seo_id_foreign');
		});
		Schema::table('con_page_option', function(Blueprint $table) {
			$table->dropForeign('con_page_option_page_id_foreign');
		});
		Schema::table('con_page_option', function(Blueprint $table) {
			$table->dropForeign('con_page_option_option_id_foreign');
		});
		Schema::table('con_page_section', function(Blueprint $table) {
			$table->dropForeign('con_page_section_page_id_foreign');
		});
		Schema::table('con_page_section', function(Blueprint $table) {
			$table->dropForeign('con_page_section_section_id_foreign');
		});
		Schema::table('con_page_media', function(Blueprint $table) {
			$table->dropForeign('con_page_media_page_id_foreign');
		});
		Schema::table('con_page_media', function(Blueprint $table) {
			$table->dropForeign('con_page_media_media_id_foreign');
		});
		Schema::table('con_page_modules', function(Blueprint $table) {
			$table->dropForeign('con_page_modules_page_id_foreign');
		});
		Schema::table('con_page_modules', function(Blueprint $table) {
			$table->dropForeign('con_page_modules_module_id_foreign');
		});
		Schema::table('con_module_records', function(Blueprint $table) {
			$table->dropForeign('con_module_records_module_id_foreign');
		});
		Schema::table('con_record_section', function(Blueprint $table) {
			$table->dropForeign('con_record_section_record_id_foreign');
		});
		Schema::table('con_record_section', function(Blueprint $table) {
			$table->dropForeign('con_record_section_section_id_foreign');
		});
        Schema::table('con_section_media', function(Blueprint $table) {
            $table->dropForeign('con_section_media_section_id_foreign');
        });
        Schema::table('con_section_media', function(Blueprint $table) {
            $table->dropForeign('con_section_media_media_id_foreign');
        });
		Schema::table('con_record_media', function(Blueprint $table) {
			$table->dropForeign('con_record_media_record_id_foreign');
		});
		Schema::table('con_record_media', function(Blueprint $table) {
			$table->dropForeign('con_record_media_media_id_foreign');
		});
		Schema::table('con_record_option', function(Blueprint $table) {
			$table->dropForeign('con_record_option_record_id_foreign');
		});
		Schema::table('con_record_option', function(Blueprint $table) {
			$table->dropForeign('con_record_option_option_id_foreign');
		});
		Schema::table('con_record_seo', function(Blueprint $table) {
			$table->dropForeign('con_record_seo_record_id_foreign');
		});
		Schema::table('con_record_seo', function(Blueprint $table) {
			$table->dropForeign('con_record_seo_seo_id_foreign');
		});
		Schema::table('nodes', function(Blueprint $table) {
			$table->dropForeign('nodes_navigation_id_foreign');
		});
		Schema::table('nodes', function(Blueprint $table) {
			$table->dropForeign('nodes_page_id_foreign');
		});
		Schema::table('con_form_submit', function(Blueprint $table) {
			$table->dropForeign('con_form_submit_form_id_foreign');
		});
		Schema::table('con_form_submit', function(Blueprint $table) {
			$table->dropForeign('con_form_submit_submit_id_foreign');
		});
		Schema::table('con_form_control', function(Blueprint $table) {
			$table->dropForeign('con_form_control_form_id_foreign');
		});
        Schema::table('con_form_control', function(Blueprint $table) {
            $table->dropForeign('con_form_control_control_id_foreign');
        });
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_role_foreign');
        });
	}
}