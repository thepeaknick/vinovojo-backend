<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WinePathMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {

            $table->increments('id');
            

            // $table->string('name');

            $table->integer('start_id')->unsigned();
            $table->foreign('start_id')
                  ->references('id')
                  ->on('pins')
                  ->onDelete('restrict');

            $table->integer('end_id')->unsigned();
            $table->foreign('end_id')
                  ->references('id')
                  ->on('pins')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\WinePath::all()->each( function($area) {
            $area->delete();
        });
        Schema::dropIfExists('routes');
    }
}
