<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class PathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $paths = json_decode($this->json, true);

        foreach ($paths as $route) {
            $waypoints = $route['waypoints'];
            // $override = [
            //     'start_lat' => $path['startDestination']['lat'],
            //     'start_lng' => $path['startDestination']['lng'],
            //     'end_lat' => $path['endDestination']['lat'],
            //     'end_lng' => $path['endDestination']['lng'],
            //     'name' => $path['titleWineRoad']
            // ];
            factory(\App\WinePath::class, 1)->make(/*$override*/)->each(function ($path) use ($waypoints, $route) {

                $start = new \App\Pin;
                $start->lat = $route['startDestination']['lat'];
                $start->lng = $route['startDestination']['lng'];
                $start->name = 'Poćetak';
                $start->object_type = $path->flag;
                $start->object_id = 1;

                $start->save();

                $end = new App\Pin;
                $end->lat = $route['endDestination']['lat'];
                $end->lng = $route['endDestination']['lng'];
                $end->name = 'Zavrsetak';

                $end->object_type = $path->flag;
                $end->object_id = 1;

                $end->save();

                $name = $path->name;
                unset($path->name);
                $path->start_id = $start->id;
                $path->end_id = $end->id;
                $path->save();

                $start->object_id = $path->id;
                $start->save();

                $end->object_id = $path->id;
                $end->save();

                $txt = new \App\TextField;
                $txt->object_id = $path->id;
                $txt->object_type = $path->flag;
                $txt->language_id = 1;

                $txt->name = 'name';
                $txt->value = $name;
                $txt->save();

                $faker = Faker::create();
                foreach ($waypoints as $wp) {
                    $override = [
                        'lat' => $wp['lat'],
                        'lng' => $wp['lng'],
                        'object_type' => $path->flag,
                        'object_id' => $path->id,
                        'name' => $faker->company,
                        'address' => $faker->address
                    ];
                    factory(\App\Pin::class, 1)->create($override);
                }

            });
        }

        // factory(\App\WinePath::class, 5)->make()->each(function ($path) {

        //     $name = $path->name;
        //     unset($path->name);
        //     $path->save();

        //     $txt = new \App\TextField;
        //     $txt->object_id = $path->id;
        //     $txt->object_type = $path->flag;
        //     $txt->language_id = 1;

        //     $txt->name = 'name';
        //     $txt->value = $name;
        //     $txt->save();

        // 	factory(\App\Pin::class, 5)->create(['object_id' => $path->id, 'object_type' => $path->flag]);
        // });
    }

    private $json = '[{
        "id": 0,
        "imagePath": "https://i1.wp.com/serbianoutdoor.com/wp-content/uploads/2013/02/vinograd.jpg",
        "titleWineRoad": "Istočna Srbija",
        "startDestination": {
            "lat": 43.206870,
            "lng": 22.315383
        },
        "endDestination": {
            "lat": 44.231122,
            "lng": 22.535110
        },
        "waypoints": [{
            "lat": 43.327601,
            "lng": 22.023630
        }]
    },
    {
        "id": 1,
        "imagePath": "http://belgraderunningclub.com/wp-content/uploads/2016/08/fruska-gora-2-e1471384635942.jpg",
        "titleWineRoad": "Fruškogorski put",
        "startDestination": {
            "lat": 45.267047,
            "lng": 19.833519
        },
        "endDestination": {
            "lat": 45.101170,
            "lng": 19.861665
        },
        "waypoints": [{
            "lat": 45.267047,
            "lng": 19.833519
        }]
    }
]';

}
