<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id')->unsigned()->references('id')->on('sections');
            $table->integer('module_id')->unsigned()->references('id')->on('pages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_sections');
    }
}
