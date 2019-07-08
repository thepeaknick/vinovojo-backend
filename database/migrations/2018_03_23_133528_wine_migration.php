<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WineMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wines', function (Blueprint $table) {
            $table->increments('id');

            // $table->string('name');
            // $table->string('description');

            $table->integer('harvest_year');
            $table->float('serving_temp');
            $table->float('alcohol');
            $table->integer('serbia_bottles');
            $table->string('type'); // ovo videti kako funkcionise, da l je ok string

            $table->tinyInteger('recommended')->default(0);
            $table->tinyInteger('highlighted')->default(0);

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                  ->references('id')
                  ->on('wine_categories')
                  ->onDelete('restrict');

            $table->integer('classification_id')->unsigned()->nullable();

            $table->integer('winery_id')->unsigned();
            $table->foreign('winery_id')
                  ->on('wineries')
                  ->references('id')
                  ->onDelete('cascade');

            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')
                  ->references('id')
                  ->on('areas')
                  ->onDelete('restrict');

            $table->tinyInteger('background')->unsigned()->default(0);

            $table->integer('search_count')->unsigned()->default(0);

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
        Schema::dropIfExists('wines');
    }
}
