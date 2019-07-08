<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SocialMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {

            $table->increments('id');
            
            $table->tinyInteger('social_type');
            $table->string('social_key');
            $table->string('social_id');
            $table->string('email');

            $table->string('full_name');

            $table->unique(['social_id', 'social_type']);
        });

        $db = app('db');

        $db->unprepared(
            "
            CREATE TRIGGER rate_delete AFTER DELETE ON socials
            FOR EACH ROW 
                BEGIN
                    DELETE FROM rates WHERE user_id = old.id AND user_type = old.social_type;
                END
            "
        );

        $wineFlag = (new \App\Wine)->flag;
        $wineryFlag = (new \App\Winery)->flag;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // app('db')->unprepared('DROP TRIGGER `rate_delete`');
        // app('db')->unprepared('DROP TRIGGER `wine_delete_comments`');
        // app('db')->unprepared('DROP TRIGGER `winery_delete_comments`');
        \App\Social::all()->each( function($area) {
            $area->delete();
        });
        Schema::dropIfExists('socials');
    }
}
