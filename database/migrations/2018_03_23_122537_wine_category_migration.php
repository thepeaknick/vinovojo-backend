<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WineCategoryMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wine_categories', function (Blueprint $table) {
            $table->increments('id');

            // $table->string('name'); transliteracija

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
        \App\Category::all()->each( function($area) {
            $area->delete();
        });
        Schema::dropIfExists('wine_categories');
    }
}
