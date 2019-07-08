<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FavouritesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourites', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('social_id')->unsigned();
            $table->foreign('social_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->integer('object_id');
            $table->integer('object_type');

            $table->unique(['social_id', 'object_id', 'object_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourites');
    }
}
