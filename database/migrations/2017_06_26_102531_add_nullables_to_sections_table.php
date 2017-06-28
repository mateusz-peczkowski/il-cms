<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullablesToSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
            $table->string('header')->nullable()->change();
            $table->string('view')->nullable()->change();
            $table->string('options')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->text('content')->nullable(false)->change();
            $table->string('header')->nullable(false)->change();
            $table->string('view')->nullable(false)->change();
            $table->string('options')->nullable(false)->change();
        });
    }
}
