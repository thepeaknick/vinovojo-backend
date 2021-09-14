<?php

use Illuminate\Database\Seeder;

class WinerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode($this->json, 1);

        $json[] = [
          'startDestination' => [
            'lat' => '43.324493',
            'lng' => '21.902066'
          ]
        ];

        foreach ($json as $point) {
        	factory(\App\Winery::class, 1)->make()->each( function ($winery) use ($point) {
        		$keys = ['name', 'description'];
                $values = $winery->only($keys);
               
               foreach ($keys as $key) {
                unset($winery->$key);
               }

               $winery->area_id = \App\Area::first()->first()->id;

               $winery->save();

               $lat = $point['startDestination']['lat'];
               $lng = $point['startDestination']['lng'];

               factory(\App\Pin::class, 1)->create(['object_id' => $winery->id, 'object_type' => $winery->flag, 'lat' => $lat, 'lng' => $lng]);


               foreach ( \App\Language::all() as $lang ) {
                    factory(\App\Winery::class, 1)->make()->each( function ($win) use ($lang, $winery) {
                        
                        $values = $win->only(['name', 'description']);


                        foreach ($values as $key => $value) {
                            $txt = new \App\TextField;
                            $txt->object_type = $winery->flag;
                            $txt->object_id = $winery->id;
                            $txt->name = $key;
                            $txt->value = $value;
                            $txt->language_id = $lang->id;
                            $txt->save();
                        }
                    });
               }

                for ($i = 0; $i < 10; $i++) {
                    $rate = new \App\Rate;
                    $rate->object_type = $winery->flag;
                    $rate->object_id = $winery->id;
                    $rate->rate = rand(1, 5);
                    $rate->comment = 'Mnogo e dobro';
                    $rate->user_id = 1;
                    $rate->status = rand() % 3;
                    $rate->save();
                }

            });
        }

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
