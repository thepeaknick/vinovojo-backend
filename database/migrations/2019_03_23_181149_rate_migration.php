<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RateMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('rate');

            $table->tinyInteger('object_type'); // koristi flagove
            $table->integer('object_id');

            $table->integer('user_id')->unsigned();
            $table->tinyInteger('user_type');

            $table->string('comment')->nullable();

            $table->enum('status', ['unapproved', 'hold', 'approved'])->default('hold');

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
        Schema::dropIfExists('rates');
    }
}
