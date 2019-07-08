<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MapPin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pins', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('object_id');
            //1 za path, 2 za area, 3 za POI
            $table->tinyInteger('object_type');

            $table->integer('type')->default(21);

            $table->string('name')->nullable();
            $table->string('address')->nullable();
            

            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        app('db')->unprepared('DROP TRIGGER IF EXISTS `path_delete_pins`');
        app('db')->unprepared('DROP TRIGGER IF EXISTS `area_delete_pins`');
        app('db')->unprepared('DROP TRIGGER IF EXISTS `poi_delete_pins`');
        Schema::dropIfExists('pins');
    }
}
