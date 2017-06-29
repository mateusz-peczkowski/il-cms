<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitemapOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitemap_options', function (Blueprint $table) {
            $table->increments('id');
            $table->text('url');
            $table->text('media');
            $table->enum('element_type', ['page', 'module'])->default('page');
            $table->enum('update_frequency', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->float('priorty')->default(0.9);
            $table->text('translations')->nullable();
            $table->integer('who_updated')->unsigned()->nullable();
            $table->enum('status', array('1', '2', '3', '4'));
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
        Schema::dropIfExists('sitemap_options');
    }
}
