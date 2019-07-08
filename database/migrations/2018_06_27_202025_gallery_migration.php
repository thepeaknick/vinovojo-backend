<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GalleryMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function(Blueprint $table) {
            $table->increments('id');

            $table->string('filename');
            $table->string('path');
            $table->integer('position');

            $table->integer('winery_id')->unsigned();
            $table->foreign('winery_id')
                  ->references('id')
                  ->on('wineries')
                  ->onDelete('cascade');

            $table->unique(['filename', 'winery_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
