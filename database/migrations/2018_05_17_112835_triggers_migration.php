<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggersMigration extends Migration
{
    
    public $triggers = [
        'areas_delete_fields',
        'articles_delete_fields',
        // 'categories_delete_fields',
        'events_delete_fields',
        'pois_delete_fields',
        'wine_delete_fields',
        'path_delete_fields',
        'wineries_delete_fields',
        'path_delete_pins',
        'area_delete_pins',
        'poi_delete_pins',
    ];

    public function up()
    {
        

        $db = app('db');

        $db->unprepared(
            "
            CREATE TRIGGER articles_delete_fields AFTER DELETE ON articles
            FOR EACH ROW 
                BEGIN
                    DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\Article)->flag . ";
                END
            "
        );

        // $db->unprepared(
        //     "
        //     CREATE TRIGGER categories_delete_fields AFTER DELETE ON wine_categories
        //     FOR EACH ROW
        //         BEGIN
        //             DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\Category)->flag . ";
        //         END
        //     "
        // );

        $db->unprepared(
            "
            CREATE TRIGGER events_delete_fields AFTER DELETE ON events
            FOR EACH ROW 
                BEGIN
                    DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\Happening)->flag . ";
                END
            "
        );

        $db->unprepared(
            "
            CREATE TRIGGER wine_delete_fields AFTER DELETE ON wines
            FOR EACH ROW 
                BEGIN
                    DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\Wine)->flag . ";
                    DELETE FROM rates WHERE object_id = old.id AND object_type = " . (new \App\Wine)->flag . ";
                    DELETE FROM rates WHERE object_id = old.id AND object_type = " . (new \App\Winery)->flag . ";
                END
            "
        );


        $db->unprepared(
            "
            CREATE TRIGGER wineries_delete_fields AFTER DELETE ON wineries
            FOR EACH ROW 
                BEGIN
                    DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\Winery)->flag . ";
                END
            "
        );





        // Za pinove

        $db->unprepared(
            "
            CREATE TRIGGER path_delete_pins AFTER DELETE ON routes
            FOR EACH ROW 
                BEGIN
                    DELETE FROM pins WHERE object_id = old.id AND object_type = 1;
                    DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\WinePath)->flag . ";
                END
            "
        );

        // $db->unprepared(
        //     "
        //     CREATE TRIGGER path_delete_fields AFTER DELETE ON routes
        //     FOR EACH ROW 
        //         BEGIN
        //             DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\WinePath)->flag . ";
        //     END
        //     "
        // );


        $db->unprepared(
            "
            CREATE TRIGGER area_delete_pins AFTER DELETE ON areas 
            FOR EACH ROW
                BEGIN
                    DELETE FROM pins WHERE object_id = old.id AND object_type = 2;
                    DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\Area)->flag . ";
                END
            "
        );

        $db->unprepared(
            "
            CREATE TRIGGER poi_delete_pins AFTER DELETE ON pois
            FOR EACH ROW
                BEGIN
                    DELETE FROM pins WHERE object_id = old.id AND object_type = 3;
                    DELETE FROM text_fields WHERE object_id = old.id AND object_type = " . (new \App\PointOfInterest)->flag . ";
                END
            "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // $db = app('db');
        // foreach ($this->triggers as $trigger) 
        //     $db->unprepared("DROP TRIGGER IF EXISTS " . $trigger . ";");
    }
}
