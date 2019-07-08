<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WineryMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wineries', function (Blueprint $table) {
            $table->increments('id');

            // $table->string('name');      // Transliteracija
            // $table->string('description');

            $table->string('address');
            $table->tinyInteger('recommended')->default(0);

            $table->string('webpage')->nullable();

            $table->string('ponpet')->nullable();
            $table->string('sub')->nullable();
            $table->string('ned')->nullable();

            $table->integer('area_id')->unsigned();
            $table->foreign('area_id')
                  ->references('id')
                  ->on('areas')
                  ->onDelete('restrict');

            $table->string('contact_person')->nullable();
            $table->string('contact')->nullable();

            $table->tinyInteger('highlighted')->default(0);

            $table->integer('search_count')->unsigned()->default(0);

            $table->timestamps();
        });

        Schema::create('user_winery', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

          $table->integer('winery_id')->unsigned();
          $table->foreign('winery_id')
                ->references('id')
                ->on('wineries')
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
        \App\Winery::all()->each( function($area) {
            $area->delete();
        });
        Schema::dropIfExists('user_winery');
        Schema::dropIfExists('wineries');
    }
}
