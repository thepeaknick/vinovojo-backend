<?php

use Illuminate\Database\Seeder;

use Intervention\Image\ImageManagerStatic as Image;

class WineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    function __construct() {
        $this->extractedJson = json_decode($this->json, true);
    }

    private $extractedJson = null;


    public function run()
    {
        $areas = \App\Area::pluck('id');

        $wineries = $this->extractedJson['wineries'];
        $wines = $this->extractedJson['wines'];
        $paths = $this->extractedJson['wineRoads'];


        foreach ($wineries as $index => $winery) {
            if ($index > 2)
              break;
            factory(\App\Winery::class, 1)->make( [ 'area_id' => $areas->random() ] )->each(function ($instance) use ($winery) {
                $instance->name = $winery['name'];
                $instance['description'] = $winery['description'];
                $instance->address = $winery['address'];
                $instance->recommended = ($winery['recommendation']) ? 1 : 0;


                $keys = ['name', 'description'];
                $values = $instance->only($keys);
               
               foreach ($keys as $key) {
                unset($instance->$key);
               }

               $instance->save();

               Image::make($winery['imageMainPath'])->save( $instance->coverFullPath() );
               Image::make($winery['imageLogoPath'])->save( $instance->logoFullPath() );

               factory(\App\Pin::class, 1)->create([
                  'object_id' => $instance->id, 
                  'object_type' => $instance->flag,
                  'lat' => $winery['lat'],
                  'lng' => $winery['lng']
                ]);

               $txt = new \App\TextField;
               $txt->object_type = $instance->flag;
               $txt->object_id = $instance->id;
               $txt->name = 'name';
               $txt->value = $winery['name'];
               $txt->language_id = 1;
               $txt->save();

               $txt = new \App\TextField;
               $txt->object_type = $instance->flag;
               $txt->object_id = $instance->id;
               $txt->name = 'description';
               $txt->value = $winery['description'];
               $txt->language_id = 1;
               $txt->save();

               foreach ( \App\Language::skip(1)->take(50)->get() as $lang ) {
                    factory(\App\Winery::class, 1)->make()->each( function ($win) use ($lang, $instance) {
                        
                        $values = $win->only(['name', 'description']);

                        foreach ($values as $key => $value) {
                            $txt = new \App\TextField;
                            $txt->object_type = $instance->flag;
                            $txt->object_id = $instance->id;
                            $txt->name = $key;
                            $txt->value = $value;
                            $txt->language_id = $lang->id;
                            $txt->save();
                        }

                        for ($i = 0; $i < 10; $i++) {
                            $rate = new \App\Rate;
                            $rate->object_type = $instance->flag;
                            $rate->object_id = $instance->id;
                            $rate->rate = rand(1, 5);
                            $rate->comment = 'Tekst komentara.';
                            $rate->user_id = 1;
                            $rate->status = (rand() % 3) + 1;
                            $rate->save();
                        }
                    });
               }

                for ($i = 0; $i < 10; $i++) {
                    $rate = new \App\Rate;
                    $rate->object_type = $instance->flag;
                    $rate->object_id = $instance->id;
                    $rate->rate = rand(1, 5);
                    $rate->comment = 'Tekst komentara.';
                    $rate->user_id = 1;
                    $rate->status = (rand() % 3) + 1;
                    $rate->save();
                }

            });
        }


        $wineries = \App\Winery::pluck('id');

        $categories = [
          'CRVENA VINA', 'BELA VINA', 'ROZE VINA', 'PENUŠAVA VINA', 'DESERTNA VINA'
        ];

        foreach ($categories as $category) {
            factory(\App\Category::class, 1)->make(['name' => $category])->each(function ($c) use ($wineries, $areas) {

              $name = $c->name;
              unset($c->name);
              $c->save();

              $txt = new \App\TextField;
              $txt->object_type = $c->flag;
              $txt->object_id = $c->id;
              $txt->name = 'name';
              $txt->value = $name;
              $txt->language_id = 1;
              $txt->save();

          });
        }

        foreach ($wines as $wine)
              factory(\App\Wine::class, 1)->make(['category_id' => \App\Category::inRandomOrder()->first()->id, 'winery_id' => \App\Winery::inRandomOrder()->first()->id])->each(function ($instance) use ($wine) {
                    $instance->name = $wine['nameWine'];
                    $instance->description = $wine['description'];
                    $instance->harvest_year = $wine['graphsHarvest'];
                    $instance->serving_temp = $wine['servingTemperature'];
                    $instance->recommended = ($wine['recommendation']) ? 1 : 0;
                    $instance->area_id = \App\Area::inRandomOrder()->first()->id;


                    $keys = ['name', 'description'];
                    $values = $instance->only($keys);
                   
                   foreach ($keys as $key) {
                     unset($instance->$key);
                   }

                    $instance->save();

                    $classes = [];
                     foreach ( \App\WineClass::all() as $class) {
                        if (rand() % 2)
                          $classes[] = $class->id;
                     }

                     $instance->classes()->attach($classes);

                    Image::make($wine['imageBottlePath'])->save( $instance->bottleFullPath() );

                    for ($i = 0; $i < 10; $i++) {
                        $rate = new \App\Rate;
                        $rate->object_type = $instance->flag;
                        $rate->object_id = $instance->id;
                        $rate->rate = rand(1, 5);
                        $rate->comment = 'Mnogo e dobro';
                        $rate->user_id = 1;
                        $rate->save();
                    }

                    foreach ($values as $key => $value) {
                        $txt = new \App\TextField;
                        $txt->object_type = $instance->flag;
                        $txt->object_id = $instance->id;
                        $txt->name = $key;
                        $txt->value = $value;
                        $txt->language_id = 1;
                        $txt->save();
                    }

                    $langs = \App\Language::where('id', '!=', 1)->get();

                    foreach ($langs as $lang) {
                      factory(\App\Wine::class, 1)->make()->each( function($wine) use ($lang, $instance) {
                        $txts = $wine->only(['name', 'description']);

                        foreach ($txts as $name => $value) {
                          $field = new \App\TextField;
                          $field->object_id = $instance->id;
                          $field->object_type = $instance->flag;
                          $field->name = $name;
                          $field->value = $value;
                          $field->language_id = $lang->id;
                          $field->save();
                        }
                      });
                    }
                });




    }

    private $json = '{
  "wineries": [
    {
      "id": 0,
      "imageMainPath": "http://www.vinarijazvonkobogdan.com/sites/default/files/2016-11/1000x777-ZB_0.jpg",
      "imageLogoPath": "http://www.silbo.rs/sw4i/thumbnail/zvonko-bogdan-v.png?thumbId=18472",
      "name": "Vinarija Zvonko Bogdan",
      "description": "Vođeni tragom istorije otkrili smo tradiciju i potencijal našeg podneblja koje vekovima rađa najkvalitetnije sorte vinove loze i daje autentična i prepoznatljiva vina internacionalnog karaktera. Poseban teroar, uz primenu najsavremenije tehnologije i finese svetski poznatih stručnjaka iz oblasti enologije, zatvaraju krug o vinu jedinstvenog karaktera.Vina Vinarije Zvonko Bogdan nose pečat podneblja na kojem nastaju i oslikavaju našu beskompromisnu težnju ka kvalitetu. ",
      "address": "Kanjiški put 45, Palić, Serbia",
      "lat": 46.091630,
      "lng": 19.779073,
      "lastRating": 4.3,
      "recommendation": true,
      "totalNumberVoicesRating": "56"
    },
    {
      "id": 1,
      "imageMainPath": "http://www.podrummalca.com/v2/wp-content/uploads/2015/07/slider-vinarija-malca-02b.jpg",
      "imageLogoPath": "http://www.podrummalca.com/wp-content/uploads/2017/07/vinski-podrum-malca-logo.png",
      "name": "Vinarija Podrum Malča",
      "description": "Vi ljubitelji vina, moći ćete da u preko 110 godina starom vinskom podrumu doživite svojevrsno putovanje kroz vinsko vreme. U razgledanju 4 potpuno različita načina negovanja vina, doživećete 4 različite vinske epohe i uživati u vinima karakterističnim za ta vremena. U sklopu podruma je i restoran “gostionica na vinskom putu” sa nesvakidašnjom ponudom hrane iz različitih vremenskih epoha, a to su: Rimski,  Srpski, Vegeterijanski i meni iz doba Nemanjića.",
      "address": "Malča bb,18207 Malča,Republika Srbija",
      "lat": 43.328455,
      "lng": 22.023785,
      "lastRating": 5.0,
      "recommendation": false,
      "totalNumberVoicesRating": "20"
    },
    {
      "id": 2,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-6.jpg",
      "imageLogoPath": "https://www.vinoflix.de/media/image/ee/d7/b0/weingut-aleksic.jpg",
      "name": "Vinarija “Aleksić” d.o.o.",
      "description": "Vinarija Aleksić se nalazi na području sa najvećim brojem sunčanih dana, na samo 2km od najužeg centra Vranja i 500m od isključenja sa međunarodnog autoputa E-75. Grad sa bogatom kulturom i istorijom prostire se na samom jugu Srbije, udaljenom 350km od Beograda, smeštenom u jugoistočnom delu vranjske kotline, na levoj obali Južne Morave.Pored proizvodnje nudimo Vam i obilazak vinarije uz degustaciju vina u bariqque ili degustacionoj sali, u zavisnosti od broja posetioca. Degustacija podrazumeva obilazak proizvodnje i probu vina uz pratnju stručnog lica.\nU mogucnosti smo da Vam organizujemo team buildinge, seminare i proslave firme do 80 osoba ili koktel večeri do 150 osoba.",
      "address": "Industrijski blok 9/1, 17500 Vranje",
      "lat": 42.551731,
      "lng": 21.926363,
      "lastRating": 5.0,
      "recommendation": true,
      "totalNumberVoicesRating": "20"
    }, {
      "id": 3,
      "imageMainPath": "http://www.vinarijazvonkobogdan.com/sites/default/files/2016-11/1000x777-ZB_0.jpg",
      "imageLogoPath": "http://www.silbo.rs/sw4i/thumbnail/zvonko-bogdan-v.png?thumbId=18472",
      "name": "Vinarija Zvonko Bogdan",
      "description": "Vođeni tragom istorije otkrili smo tradiciju i potencijal našeg podneblja koje vekovima rađa najkvalitetnije sorte vinove loze i daje autentična i prepoznatljiva vina internacionalnog karaktera. Poseban teroar, uz primenu najsavremenije tehnologije i finese svetski poznatih stručnjaka iz oblasti enologije, zatvaraju krug o vinu jedinstvenog karaktera.Vina Vinarije Zvonko Bogdan nose pečat podneblja na kojem nastaju i oslikavaju našu beskompromisnu težnju ka kvalitetu. ",
      "address": "Kanjiški put 45, Palić, Serbia",
      "lat": 46.091630,
      "lng": 19.779073,
      "lastRating": 4.3,
      "recommendation": true,
      "totalNumberVoicesRating": "56"
    },
    {
      "id": 4,
      "imageMainPath": "http://www.podrummalca.com/v2/wp-content/uploads/2015/07/slider-vinarija-malca-02b.jpg",
      "imageLogoPath": "http://www.podrummalca.com/wp-content/uploads/2017/07/vinski-podrum-malca-logo.png",
      "name": "Vinarija Podrum Malča",
      "description": "Vi ljubitelji vina, moći ćete da u preko 110 godina starom vinskom podrumu doživite svojevrsno putovanje kroz vinsko vreme. U razgledanju 4 potpuno različita načina negovanja vina, doživećete 4 različite vinske epohe i uživati u vinima karakterističnim za ta vremena. U sklopu podruma je i restoran “gostionica na vinskom putu” sa nesvakidašnjom ponudom hrane iz različitih vremenskih epoha, a to su: Rimski,  Srpski, Vegeterijanski i meni iz doba Nemanjića.",
      "address": "Malča bb,18207 Malča,Republika Srbija",
      "lat": 43.328455,
      "lng": 22.023785,
      "lastRating": 5.0,
      "recommendation": false,
      "totalNumberVoicesRating": "20"
    },
    {
      "id": 5,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-6.jpg",
      "imageLogoPath": "https://www.vinoflix.de/media/image/ee/d7/b0/weingut-aleksic.jpg",
      "name": "Vinarija “Aleksić” d.o.o.",
      "description": "Vinarija Aleksić se nalazi na području sa najvećim brojem sunčanih dana, na samo 2km od najužeg centra Vranja i 500m od isključenja sa međunarodnog autoputa E-75. Grad sa bogatom kulturom i istorijom prostire se na samom jugu Srbije, udaljenom 350km od Beograda, smeštenom u jugoistočnom delu vranjske kotline, na levoj obali Južne Morave.Pored proizvodnje nudimo Vam i obilazak vinarije uz degustaciju vina u bariqque ili degustacionoj sali, u zavisnosti od broja posetioca. Degustacija podrazumeva obilazak proizvodnje i probu vina uz pratnju stručnog lica.\nU mogucnosti smo da Vam organizujemo team buildinge, seminare i proslave firme do 80 osoba ili koktel večeri do 150 osoba.",
      "address": "Industrijski blok 9/1, 17500 Vranje",
      "lat": 42.551731,
      "lng": 21.926363,
      "lastRating": 5.0,
      "recommendation": true,
      "totalNumberVoicesRating": "20"
    }, {
      "id": 6,
      "imageMainPath": "http://www.vinarijazvonkobogdan.com/sites/default/files/2016-11/1000x777-ZB_0.jpg",
      "imageLogoPath": "http://www.silbo.rs/sw4i/thumbnail/zvonko-bogdan-v.png?thumbId=18472",
      "name": "Vinarija Zvonko Bogdan",
      "description": "Vođeni tragom istorije otkrili smo tradiciju i potencijal našeg podneblja koje vekovima rađa najkvalitetnije sorte vinove loze i daje autentična i prepoznatljiva vina internacionalnog karaktera. Poseban teroar, uz primenu najsavremenije tehnologije i finese svetski poznatih stručnjaka iz oblasti enologije, zatvaraju krug o vinu jedinstvenog karaktera.Vina Vinarije Zvonko Bogdan nose pečat podneblja na kojem nastaju i oslikavaju našu beskompromisnu težnju ka kvalitetu. ",
      "address": "Kanjiški put 45, Palić, Serbia",
      "lat": 46.091630,
      "lng": 19.779073,
      "lastRating": 4.3,
      "recommendation": true,
      "totalNumberVoicesRating": "56"
    },
    {
      "id": 7,
      "imageMainPath": "http://www.podrummalca.com/v2/wp-content/uploads/2015/07/slider-vinarija-malca-02b.jpg",
      "imageLogoPath": "http://www.podrummalca.com/wp-content/uploads/2017/07/vinski-podrum-malca-logo.png",
      "name": "Vinarija Podrum Malča",
      "description": "Vi ljubitelji vina, moći ćete da u preko 110 godina starom vinskom podrumu doživite svojevrsno putovanje kroz vinsko vreme. U razgledanju 4 potpuno različita načina negovanja vina, doživećete 4 različite vinske epohe i uživati u vinima karakterističnim za ta vremena. U sklopu podruma je i restoran “gostionica na vinskom putu” sa nesvakidašnjom ponudom hrane iz različitih vremenskih epoha, a to su: Rimski,  Srpski, Vegeterijanski i meni iz doba Nemanjića.",
      "address": "Malča bb,18207 Malča,Republika Srbija",
      "lat": 43.328455,
      "lng": 22.023785,
      "lastRating": 5.0,
      "recommendation": false,
      "totalNumberVoicesRating": "20"
    },
    {
      "id": 8,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-6.jpg",
      "imageLogoPath": "https://www.vinoflix.de/media/image/ee/d7/b0/weingut-aleksic.jpg",
      "name": "Vinarija “Aleksić” d.o.o.",
      "description": "Vinarija Aleksić se nalazi na području sa najvećim brojem sunčanih dana, na samo 2km od najužeg centra Vranja i 500m od isključenja sa međunarodnog autoputa E-75. Grad sa bogatom kulturom i istorijom prostire se na samom jugu Srbije, udaljenom 350km od Beograda, smeštenom u jugoistočnom delu vranjske kotline, na levoj obali Južne Morave.Pored proizvodnje nudimo Vam i obilazak vinarije uz degustaciju vina u bariqque ili degustacionoj sali, u zavisnosti od broja posetioca. Degustacija podrazumeva obilazak proizvodnje i probu vina uz pratnju stručnog lica.\nU mogucnosti smo da Vam organizujemo team buildinge, seminare i proslave firme do 80 osoba ili koktel večeri do 150 osoba.",
      "address": "Industrijski blok 9/1, 17500 Vranje",
      "lat": 42.551731,
      "lng": 21.926363,
      "lastRating": 5.0,
      "recommendation": true,
      "totalNumberVoicesRating": "20"
    },
        {
      "id": 9,
      "imageMainPath": "http://www.vinarijazvonkobogdan.com/sites/default/files/2016-11/1000x777-ZB_0.jpg",
      "imageLogoPath": "http://www.silbo.rs/sw4i/thumbnail/zvonko-bogdan-v.png?thumbId=18472",
      "name": "Vinarija Zvonko Bogdan",
      "description": "Vođeni tragom istorije otkrili smo tradiciju i potencijal našeg podneblja koje vekovima rađa najkvalitetnije sorte vinove loze i daje autentična i prepoznatljiva vina internacionalnog karaktera. Poseban teroar, uz primenu najsavremenije tehnologije i finese svetski poznatih stručnjaka iz oblasti enologije, zatvaraju krug o vinu jedinstvenog karaktera.Vina Vinarije Zvonko Bogdan nose pečat podneblja na kojem nastaju i oslikavaju našu beskompromisnu težnju ka kvalitetu. ",
      "address": "Kanjiški put 45, Palić, Serbia",
      "lat": 46.091630,
      "lng": 19.779073,
      "lastRating": 4.3,
      "recommendation": true,
      "totalNumberVoicesRating": "56"
    },
    {
      "id": 10,
      "imageMainPath": "http://www.podrummalca.com/v2/wp-content/uploads/2015/07/slider-vinarija-malca-02b.jpg",
      "imageLogoPath": "http://www.podrummalca.com/wp-content/uploads/2017/07/vinski-podrum-malca-logo.png",
      "name": "Vinarija Podrum Malča",
      "description": "Vi ljubitelji vina, moći ćete da u preko 110 godina starom vinskom podrumu doživite svojevrsno putovanje kroz vinsko vreme. U razgledanju 4 potpuno različita načina negovanja vina, doživećete 4 različite vinske epohe i uživati u vinima karakterističnim za ta vremena. U sklopu podruma je i restoran “gostionica na vinskom putu” sa nesvakidašnjom ponudom hrane iz različitih vremenskih epoha, a to su: Rimski,  Srpski, Vegeterijanski i meni iz doba Nemanjića.",
      "address": "Malča bb,18207 Malča,Republika Srbija",
      "lat": 43.328455,
      "lng": 22.023785,
      "lastRating": 5.0,
      "recommendation": false,
      "totalNumberVoicesRating": "20"
    },
    {
      "id": 11,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-6.jpg",
      "imageLogoPath": "https://www.vinoflix.de/media/image/ee/d7/b0/weingut-aleksic.jpg",
      "name": "Vinarija “Aleksić” d.o.o.",
      "description": "Vinarija Aleksić se nalazi na području sa najvećim brojem sunčanih dana, na samo 2km od najužeg centra Vranja i 500m od isključenja sa međunarodnog autoputa E-75. Grad sa bogatom kulturom i istorijom prostire se na samom jugu Srbije, udaljenom 350km od Beograda, smeštenom u jugoistočnom delu vranjske kotline, na levoj obali Južne Morave.Pored proizvodnje nudimo Vam i obilazak vinarije uz degustaciju vina u bariqque ili degustacionoj sali, u zavisnosti od broja posetioca. Degustacija podrazumeva obilazak proizvodnje i probu vina uz pratnju stručnog lica.\nU mogucnosti smo da Vam organizujemo team buildinge, seminare i proslave firme do 80 osoba ili koktel večeri do 150 osoba.",
      "address": "Industrijski blok 9/1, 17500 Vranje",
      "lat": 42.551731,
      "lng": 21.926363,
      "lastRating": 5.0,
      "recommendation": true,
      "totalNumberVoicesRating": "20"
    }, {
      "id": 12,
      "imageMainPath": "http://www.vinarijazvonkobogdan.com/sites/default/files/2016-11/1000x777-ZB_0.jpg",
      "imageLogoPath": "http://www.silbo.rs/sw4i/thumbnail/zvonko-bogdan-v.png?thumbId=18472",
      "name": "Vinarija Zvonko Bogdan",
      "description": "Vođeni tragom istorije otkrili smo tradiciju i potencijal našeg podneblja koje vekovima rađa najkvalitetnije sorte vinove loze i daje autentična i prepoznatljiva vina internacionalnog karaktera. Poseban teroar, uz primenu najsavremenije tehnologije i finese svetski poznatih stručnjaka iz oblasti enologije, zatvaraju krug o vinu jedinstvenog karaktera.Vina Vinarije Zvonko Bogdan nose pečat podneblja na kojem nastaju i oslikavaju našu beskompromisnu težnju ka kvalitetu. ",
      "address": "Kanjiški put 45, Palić, Serbia",
      "lat": 46.091630,
      "lng": 19.779073,
      "lastRating": 4.3,
      "recommendation": true,
      "totalNumberVoicesRating": "56"
    },
    {
      "id": 13,
      "imageMainPath": "http://www.podrummalca.com/v2/wp-content/uploads/2015/07/slider-vinarija-malca-02b.jpg",
      "imageLogoPath": "http://www.podrummalca.com/wp-content/uploads/2017/07/vinski-podrum-malca-logo.png",
      "name": "Vinarija Podrum Malča",
      "description": "Vi ljubitelji vina, moći ćete da u preko 110 godina starom vinskom podrumu doživite svojevrsno putovanje kroz vinsko vreme. U razgledanju 4 potpuno različita načina negovanja vina, doživećete 4 različite vinske epohe i uživati u vinima karakterističnim za ta vremena. U sklopu podruma je i restoran “gostionica na vinskom putu” sa nesvakidašnjom ponudom hrane iz različitih vremenskih epoha, a to su: Rimski,  Srpski, Vegeterijanski i meni iz doba Nemanjića.",
      "address": "Malča bb,18207 Malča,Republika Srbija",
      "lat": 43.328455,
      "lng": 22.023785,
      "lastRating": 5.0,
      "recommendation": false,
      "totalNumberVoicesRating": "20"
    },
    {
      "id": 14,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-6.jpg",
      "imageLogoPath": "https://www.vinoflix.de/media/image/ee/d7/b0/weingut-aleksic.jpg",
      "name": "Vinarija “Aleksić” d.o.o.",
      "description": "Vinarija Aleksić se nalazi na području sa najvećim brojem sunčanih dana, na samo 2km od najužeg centra Vranja i 500m od isključenja sa međunarodnog autoputa E-75. Grad sa bogatom kulturom i istorijom prostire se na samom jugu Srbije, udaljenom 350km od Beograda, smeštenom u jugoistočnom delu vranjske kotline, na levoj obali Južne Morave.Pored proizvodnje nudimo Vam i obilazak vinarije uz degustaciju vina u bariqque ili degustacionoj sali, u zavisnosti od broja posetioca. Degustacija podrazumeva obilazak proizvodnje i probu vina uz pratnju stručnog lica.\nU mogucnosti smo da Vam organizujemo team buildinge, seminare i proslave firme do 80 osoba ili koktel večeri do 150 osoba.",
      "address": "Industrijski blok 9/1, 17500 Vranje",
      "lat": 42.551731,
      "lng": 21.926363,
      "lastRating": 5.0,
      "recommendation": true,
      "totalNumberVoicesRating": "20"
    }, {
      "id": 15,
      "imageMainPath": "http://www.vinarijazvonkobogdan.com/sites/default/files/2016-11/1000x777-ZB_0.jpg",
      "imageLogoPath": "http://www.silbo.rs/sw4i/thumbnail/zvonko-bogdan-v.png?thumbId=18472",
      "name": "Vinarija Zvonko Bogdan",
      "description": "Vođeni tragom istorije otkrili smo tradiciju i potencijal našeg podneblja koje vekovima rađa najkvalitetnije sorte vinove loze i daje autentična i prepoznatljiva vina internacionalnog karaktera. Poseban teroar, uz primenu najsavremenije tehnologije i finese svetski poznatih stručnjaka iz oblasti enologije, zatvaraju krug o vinu jedinstvenog karaktera.Vina Vinarije Zvonko Bogdan nose pečat podneblja na kojem nastaju i oslikavaju našu beskompromisnu težnju ka kvalitetu. ",
      "address": "Kanjiški put 45, Palić, Serbia",
      "lat": 46.091630,
      "lng": 19.779073,
      "lastRating": 4.3,
      "recommendation": true,
      "totalNumberVoicesRating": "56"
    },
    {
      "id": 16,
      "imageMainPath": "http://www.podrummalca.com/v2/wp-content/uploads/2015/07/slider-vinarija-malca-02b.jpg",
      "imageLogoPath": "http://www.podrummalca.com/wp-content/uploads/2017/07/vinski-podrum-malca-logo.png",
      "name": "Vinarija Podrum Malča",
      "description": "Vi ljubitelji vina, moći ćete da u preko 110 godina starom vinskom podrumu doživite svojevrsno putovanje kroz vinsko vreme. U razgledanju 4 potpuno različita načina negovanja vina, doživećete 4 različite vinske epohe i uživati u vinima karakterističnim za ta vremena. U sklopu podruma je i restoran “gostionica na vinskom putu” sa nesvakidašnjom ponudom hrane iz različitih vremenskih epoha, a to su: Rimski,  Srpski, Vegeterijanski i meni iz doba Nemanjića.",
      "address": "Malča bb,18207 Malča,Republika Srbija",
      "lat": 43.328455,
      "lng": 22.023785,
      "lastRating": 5.0,
      "recommendation": false,
      "totalNumberVoicesRating": "20"
    },
    {
      "id": 17,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-6.jpg",
      "imageLogoPath": "https://www.vinoflix.de/media/image/ee/d7/b0/weingut-aleksic.jpg",
      "name": "Vinarija “Aleksić” d.o.o.",
      "description": "Vinarija Aleksić se nalazi na području sa najvećim brojem sunčanih dana, na samo 2km od najužeg centra Vranja i 500m od isključenja sa međunarodnog autoputa E-75. Grad sa bogatom kulturom i istorijom prostire se na samom jugu Srbije, udaljenom 350km od Beograda, smeštenom u jugoistočnom delu vranjske kotline, na levoj obali Južne Morave.Pored proizvodnje nudimo Vam i obilazak vinarije uz degustaciju vina u bariqque ili degustacionoj sali, u zavisnosti od broja posetioca. Degustacija podrazumeva obilazak proizvodnje i probu vina uz pratnju stručnog lica.\nU mogucnosti smo da Vam organizujemo team buildinge, seminare i proslave firme do 80 osoba ili koktel večeri do 150 osoba.",
      "address": "Industrijski blok 9/1, 17500 Vranje",
      "lat": 42.551731,
      "lng": 21.926363,
      "lastRating": 5.0,
      "recommendation": true,
      "totalNumberVoicesRating": "20"
    }
  ],
  "wines": [
    {
      "id": 0,
      "idWinery": 2,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-3.jpg",
      "imageBottlePath": "http://www.podrumaleksic.rs/img/wine-zuti-cvet.png",
      "nameWine": "Žuti cvet",
      "nameWinery": "Vinarija “Aleksić” d.o.o.",
      "description": "Boja je svetložuta sa kristalnom bistrinom. Na mirisu dominiraju cvetne i herbalne aroma, sa mineralima u pozadini. Ukus blag, skladan sa vibrantnim kiselinama, laganiji sa sočnom završnicom.\n\nPogodno kao aperitivno vino. Idelano za početak obroka uz hladna predjela na bazi salata, plodove more, mlade sireve, pršutu, kao i uz belu grilovanu ili prženu ribu sa dalamatinskom garniturom. Vrlo dobro će se složiti i sa desertina, tipa tulumba, lenja pita, orasnice.",
      "addressWinery": "Industrijski blok 9/1, 17500 Vranje",
      "graphsHarvest": "2013",
      "servingTemperature": "8-10",
      "alcohol": "11",
      "sortTypeWine": 1,
      "lastRating": 4.9,
      "recommendation": true,
      "frame": false,
      "totalNumberVoicesRating": "10"
    },
    {
      "id": 1,
      "idWinery": 2,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-3.jpg",
      "imageBottlePath": "http://www.podrumaleksic.rs/img/wine-rose.png",
      "nameWine": "Rose",
      "nameWinery": "Vinarija “Aleksić” d.o.o.",
      "description": "Boja vina je nežna svetlo roze briljantnogs jaja. Miris voćni, mešavina crvenog voća, jagoda i malina sa nežnim cvetnim aromama. Ukus vina je srednjeg intenziteta, sočan sa hrskavim kiselinama.\n\nKao aperitivno vino. Idelano za početak obroka uz hladna predjela na bazi salata, mlade sireve, pršute, meso sa roštilja, pečurke, laganije crvena mesa, pice, paste.",
      "addressWinery": "Industrijski blok 9/1, 17500 Vranje",
      "graphsHarvest": "2013",
      "servingTemperature": "8-10",
      "alcohol": "13",
      "sortTypeWine": 2,
      "lastRating": 4.9,
      "recommendation": false,
      "frame": false,
      "totalNumberVoicesRating": "20"
    },
    {
      "id": 2,
      "idWinery": 2,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-3.jpg",
      "imageBottlePath": "http://www.podrumaleksic.rs/img/wine-arno.png",
      "nameWine": "Arno",
      "nameWinery": "Vinarija “Aleksić” d.o.o.",
      "description": "Boja vina je svetlija slamnato-žuta sa zelenim odsjajem. Miris sortan, navrežu paradajza sa vegetativnim tonovima i izraženom svežinom, tipičan sovinjonski. Ukus pun, sa blago naglašenim kiselinama, zaokružen sa sočnom završnicom i nagoveštajem arome sveže kafe.\n\nPogodno kao aperitivno vino. Idealno za početak obroka uz hladna predjela na bazi salata od plodova mora, bruskete, kozje sireve. Kao i uz belui plavuribugrilovanu sa dalamatinskom garniturom.",
      "addressWinery": "Industrijski blok 9/1, 17500 Vranje",
      "graphsHarvest": "2012",
      "servingTemperature": "8-10",
      "alcohol": "13,5",
      "sortTypeWine": 1,
      "lastRating": 5.0,
      "recommendation": true,
      "frame": false,
      "totalNumberVoicesRating": "82"
    },
    {
      "id": 3,
      "idWinery": 2,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-3.jpg",
      "imageBottlePath": "http://www.podrumaleksic.rs/img/wine-kardas.png",
      "nameWine": "Kardaš",
      "nameWinery": "Vinarija “Aleksić” d.o.o.",
      "description": "Vino je izrazite rubin crvene boje. Na mirisu mešavina tamnog svežeg bobičastog voća i suvih šljiva sa diskretnim nagoveštajem zemljanih aroma. Srednje punog tela sa još mladim, ali somotskim taninima. Ukus karakteriše zrela višnja i skladne kiseline. Potrebno servirati u veću čašu - kaberne tipa, kako bi vino bilo spremno za uživanje.\n\nVrlo dobro ide uz crvena mesa. Naročito uz nacionalne specijalitete kao što su jagnjetina i teletina ispod sača. Uz medaljone sa prelivom od šampinjona i zrelih sireva. I uz deserte na bazi crne čokolade kao što je čokoladni sufle sa sladoledom od vanile.",
      "addressWinery": "Industrijski blok 9/1, 17500 Vranje",
      "graphsHarvest": "2011",
      "servingTemperature": "16-18",
      "alcohol": "14",
      "sortTypeWine": 0,
      "lastRating": 4.2,
      "recommendation": false,
      "frame": false,
      "totalNumberVoicesRating": "71"
    },
    {
      "id": 4,
      "idWinery": 2,
      "imageMainPath": "http://www.podrumaleksic.rs/img/gallery/wineyard-3.jpg",
      "imageBottlePath": "http://www.podrumaleksic.rs/img/wine-nostalgija.png",
      "nameWine": "Nostalgija",
      "nameWinery": "Vinarija “Aleksić” d.o.o.",
      "description": "Vino je sjajne rubin crvene boje sa ljubičastim odsjajem. Na mirisu bogato, kompleksnost izražena kroz mešavinu slatkog crnog voća i začina. Meko i kremasto u isto vreme. Srednje punog tela, dobrog balansa i svilenih tanina. Servirati u većoj čaši - kaberne tipa.\n\nJača crvena mesa, pečenje, nacionalni roštilj. Masniji sirevi.",
      "addressWinery": "Industrijski blok 9/1, 17500 Vranje",
      "graphsHarvest": "2011",
      "servingTemperature": "16-18",
      "alcohol": "12,5",
      "sortTypeWine": 0,
      "lastRating": 4.2,
      "recommendation": false,
      "frame": false,
      "totalNumberVoicesRating": "71"
    },
    {
      "id": 5,
      "idWinery": 1,
      "imageMainPath": "http://www.podrummalca.com/wp-content/uploads/2017/09/nemanjica-kuca-vinarija-status-malca-2.jpg",
      "imageBottlePath": "http://apps.itcentar.rs/vinskiputevisrbije/images/malca/konstantin-malca.png",
      "nameWine": "Konstantin Veliki 2012",
      "nameWinery": "Vinarija Podrum Malča",
      "description": "Tamne, duboke rubin boje, karakterističnog mirisa zrelog crvenog voća sa izraženom mineralnošću. Vino izuzetne punoće i složene taninske strukture. Oštri tanini zaokružuju upečatljiv ukus ovog vina. Jedinstven, robustan karakter koji ovom vinu daje dugo odležavanje u amfori odlično je uklopljen u aromatski kompleks vina. Ovo vino se može čuvati godinama i može postajati samo bolje.\n\nOdlično se slaže sa svim vrstama crvenog mesa, jakom i začinjenom hranom, dimljenim sirevima i dimljenim mesom.",
      "addressWinery": "Malča bb,18207 Malča,Republika Srbija",
      "graphsHarvest": "2012",
      "servingTemperature": "16-18",
      "alcohol": "13,5",
      "sortTypeWine": 0,
      "lastRating": 4.2,
      "recommendation": true,
      "frame": false,
      "totalNumberVoicesRating": "71"
    },
    {
      "id": 6,
      "idWinery": 1,
      "imageMainPath": "http://www.podrummalca.com/wp-content/uploads/2017/09/nemanjica-kuca-vinarija-status-malca-1.jpg",
      "imageBottlePath": "http://apps.itcentar.rs/vinskiputevisrbije/images/malca/caricajelena-malca.png",
      "nameWine": "Carica Jelena 2012",
      "nameWinery": "Vinarija Podrum Malča",
      "description": "Belo vino, nesvakidašnje zagasito žute boje. Intenzivnog mirisa zrelog voća dunje i kruške. Na ukusu nežno, pitko, puno. Duga maceracija na pokožici u amforama i kasnije odležavanje u velikim drvenim bačvama učinile su ovo vino potpuno drugačijim od svega što ste do sada probali.\n\nCarica Jelena se odlično slaže sa vinom, laganim mesom i sirevima.",
      "addressWinery": "Malča bb,18207 Malča,Republika Srbija",
      "graphsHarvest": "2012",
      "servingTemperature": "10-12",
      "alcohol": "12",
      "sortTypeWine": 1,
      "lastRating": 4.2,
      "recommendation": true,
      "frame": false,
      "totalNumberVoicesRating": "71"
    },
    {
      "id": 7,
      "idWinery": 0,
      "imageMainPath": "https://www.winerist.com/images/sized/images/uploads/31754_93_photo_tour4-848x425.jpg",
      "imageBottlePath": "http://apps.itcentar.rs/vinskiputevisrbije/images/zvonkobogdan/zvonko-bogdan-rose.png",
      "nameWine": "Zvonko Bogdan Rose 2016",
      "nameWinery": "Vinarija Zvonko Bogdan",
      "description": "San Francisco International Wine Competition 2013 - bronzana medalja. Japan Wine Challenge 2013 - bronzana medalja. Concours Mondial de Bruxelles 2013 - srebrna medalja. AWC Vienna 2012 - srebrna medalja. San Francisco. International Wine Competition 2012 - bronzana medalja. The Balkans International Wine Competition 2012  - srebrna medalja.\n\nVino karakterišu ružičasta boja i očaravajuća svežina sa prefinjenim aromama jagode i maline i nežnim tonovima ružinog cveta. Prijatna slast i aromatičnost u završnici zaokružuju njegovu eleganciju.",
      "addressWinery": "Kanjiški put 45, Palić, Serbia",
      "graphsHarvest": "2016",
      "servingTemperature": "8",
      "alcohol": "12,5",
      "sortTypeWine": 2,
      "lastRating": 4.2,
      "recommendation": true,
      "frame": false,
      "totalNumberVoicesRating": "71"
    },
    {
      "id": 8,
      "idWinery": 0,
      "imageMainPath": "http://www.park-palic.rs/wp-content/uploads/2015/11/BARRIK-CELLAR3.jpg",
      "imageBottlePath": "http://apps.itcentar.rs/vinskiputevisrbije/images/zvonkobogdan/zvonko-bogdan-8-tamburasa.png",
      "nameWine": "8 tamburaša 2016",
      "nameWinery": "Vinarija Zvonko Bogdan",
      "description": "Vino 8 Tamburaša predstavlja jedinstvenu kupažu raskošnog bukea sa izraženim aromama breskve i dinje, obogaćenih nežnim mineralima i citrusnim tonovima i diskretnim nijansama belog livadskog cveća. Vino odiše svežinom i osvaja svojom elegancijom.\n\nIdealno vino za sve prilike, preporučujemo ga rashlađenog na temperaturu od 8 ctepeni uz sveže sezonske salate, mladi sirevi, morski plodovi...",
      "addressWinery": "Kanjiški put 45, Palić, Serbia",
      "graphsHarvest": "2016",
      "servingTemperature": "8",
      "alcohol": "13",
      "sortTypeWine": 1,
      "lastRating": 4.2,
      "recommendation": false,
      "frame": false,
      "totalNumberVoicesRating": "21"
    },
    {
      "id": 9,
      "idWinery": 0,
      "imageMainPath": "http://www.park-palic.rs/wp-content/uploads/2015/11/BARRIK-CELLAR3.jpg",
      "imageBottlePath": "http://apps.itcentar.rs/vinskiputevisrbije/images/zvonkobogdan/zvonko-bogdan-sauvignon-blanc.png",
      "nameWine": "Zvonko Bogdan Sauvignon Blanc 2016",
      "nameWinery": "Vinarija Zvonko Bogdan",
      "description": "Naš Sauvignon Blanc 2016. odlikuje široka paleta raskošnih aroma u kojoj dominiraju note ananasa, grejpfruta i marakuje.\n\n Idealan sklad dostiže uz mediteransku kuhinju, piletinu sa šparglama i mlade sireve koji istovremeno naglašavaju doživljaj istančanih voćnih aroma vina.",
      "addressWinery": "Kanjiški put 45, Palić, Serbia",
      "graphsHarvest": "2016",
      "servingTemperature": "8",
      "alcohol": "13,5",
      "sortTypeWine": 1,
      "lastRating": 3.2,
      "recommendation": false,
      "frame": false,
      "totalNumberVoicesRating": "32"
    },
    {
      "id": 10,
      "idWinery": 0,
      "imageMainPath": "http://winestyle.rs/wp-content/uploads/2015/10/zvonko-bogdan12_resize.jpg",
      "imageBottlePath": "http://apps.itcentar.rs/vinskiputevisrbije/images/zvonkobogdan/zvonko-bogdan-magnum-6l.png",
      "nameWine": "Zvonko Bogdan Cuvee No. 1 - Magnum 6l",
      "nameWinery": "Vinarija Zvonko Bogdan",
      "description": "Pažljiva selekcija grozdova, isključivo ručno branje i mali prinos po čokotu su preduslov za kvalitet. Dobijeno od tradicionalnih sorti crnog grožđa. Sazrevalo je skoro dve godine u novim hrastovim buradima.Ima izražene arome vanile, borovnice, divlje trešnje i crvenog šumskog voća. Izrazito komplekno vino koje ima veliki potencijal.\n\nPosebno ga preporučujemo uz biftek u sosu od šumskog voća kao i uz jače sireve",
      "addressWinery": "Kanjiški put 45, Palić, Serbia",
      "graphsHarvest": "2011",
      "servingTemperature": "14-16",
      "alcohol": "13,5",
      "sortTypeWine": 0,
      "lastRating": 4.9,
      "recommendation": true,
      "frame": false,
      "totalNumberVoicesRating": "26"
    }
  ],
  "wineRoads": [
    {
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
      "waypoints": [
        {
          "lat": 43.327601,
          "lng": 22.023630
        }
      ]
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
      "waypoints": [
        {
          "lat": 45.267047,
          "lng": 19.833519
        }
      ]
    }
  ]
}';

}
