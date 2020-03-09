<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            // $table->string('name', 50);
            // $table->string('description')->nullable();
            
            $table->datetime('start');
            $table->datetime('end');

            $table->string('link')->nullable();

            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
            $table->string('location');

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
        \App\Happening::all()->each( function($area) {
            $area->delete();
        });
        Schema::dropIfExists('events');
    }
}
