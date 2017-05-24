<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_content_fields', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('page_id')->references('id')->on('pages')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_content_fields', function(Blueprint $table) {
            $table->dropForeign('section_id');
        });

        Schema::table('sections', function(Blueprint $table) {
            $table->dropForeign('page_id');
        });
    }
}
