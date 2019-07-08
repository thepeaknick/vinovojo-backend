<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('type', ['regija', 'reon', 'vinogorje'])->default('regija');

            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')
            	  ->references('id')
            	  ->on('areas')
            	  ->onDelete('set null');
            

            // $table->string('name');
            // $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Area::all()->each( function($area) {
            $area->delete();
        });
        Schema::dropIfExists('areas');
    }
}
