<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HighLightMigration extends Migration
{
    public function up()
    {
        Schema::create('highlight',function(Blueprint $table){
            $table->increments('id');
            $table->integer('object_id');
            $table->enum('object_type');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('type');
        });
    }
    public function down()
    {
        Schema::dropIfExists('highlight');
    }
}

?>
