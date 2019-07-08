<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TextFieldMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_fields', function (Blueprint $table) {
            $table->increments('id');
            
            $table->tinyInteger('object_type');
            $table->integer('object_id');

            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')
                  ->references('id')
                  ->on('languages')
                  ->onDelete('cascade');

            $table->string('name');
            $table->longtext('value')->collation('UTF8_GENERAL_CI');

            $table->unique(['object_type', 'object_id', 'language_id', 'name']);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('text_fields');
    }
}
