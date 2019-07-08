<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WinetypesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wine_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('colour');
        });
        Schema::table('wines', function(Blueprint $table) {
            $table->integer('wine_type')->unsigned();
            $table->foreign('wine_type')
                  ->references('id')
                  ->on('wine_types')
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
        Schema::dropIfExists('wine_types');
    }
}
