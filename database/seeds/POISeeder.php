<?php

use Illuminate\Database\Seeder;

class POISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\PointOfInterest::class, 100)->make()->each(function ($poi) {

            $name = $poi->name;
            unset($poi->name);
            $poi->save();

            $txt = new \App\TextField;
            
            $txt->object_id = $poi->id;
            $txt->object_type = $poi->flag;
            $txt->language_id = 1;

            $txt->name = 'name';
            $txt->value = $name;

            $txt->save();

        	factory(\App\Pin::class, 1)->create(['object_id' => $poi->id, 'object_type' => $poi->flag]);
        });
    }
}
