<?php

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Area::class, 5)->make()->each(function ($area) {

            $name = $area->name;
            $description = $area->description;
            unset($area->name);
            unset($area->description);
            $area->save();

            $txt = new \App\TextField;
            $txt->object_type = $area->flag;
            $txt->object_id = $area->id;
            $txt->language_id = 1;
            $txt->name = 'name';
            $txt->value = $name;
            $txt->save();


            $txt = new \App\TextField;
            $txt->object_type = $area->flag;
            $txt->object_id = $area->id;
            $txt->language_id = 1;
            $txt->name = 'description;';
            $txt->value = $description;;
            $txt->save();


        	factory(\App\Pin::class, 10)->create(['object_id' => $area->id, 'object_type' => $area->flag]);
        });
    }
}
