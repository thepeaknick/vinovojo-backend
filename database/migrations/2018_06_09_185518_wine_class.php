<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WineClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wine_classes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
        });

        Schema::create('classes_wines', function (Blueprint $table) {
            $table->integer('wine_id')->unsigned();
            $table->foreign('wine_id')
                  ->references('id')
                  ->on('wines')
                  ->onDelete('cascade');

            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')
                  ->references('id')
                  ->on('wine_classes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes_wines');
        Schema::dropIfExists('wine_classes');
    }
}
