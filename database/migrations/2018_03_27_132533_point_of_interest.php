<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PointOfInterest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pois', function (Blueprint $table) {
            $table->increments('id');
            
            // $table->string('name');
            $table->string('address');

            $table->tinyInteger('type');
            // 20 za kafic
            // 21 za restoran
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\PointOfInterest::all()->each( function($area) {
            $area->delete();
        });
        Schema::dropIfExists('pois');
    }
}
