<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('full_name');

            $table->string('email');

            $table->string('password')->nullable();

            $table->tinyInteger('social')->default(0);

            $table->string('social_type')->nullable();
            $table->string('social_key')->nullable();
            $table->string('social_id')->nullable();

            $table->string('phone_number')->nullable();

            $table->unique(['email', 'social_type']);

            $table->enum('type', ['user', 'trusted', 'winery_admin', 'admin'])->default('user');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
