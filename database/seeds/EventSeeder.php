<?php

use Illuminate\Database\Seeder;

use Intervention\Image\ImageManagerStatic as Image;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = json_decode($this->json, 1)['events'];

        foreach ($events as $event)
        factory(\App\Happening::class, 1)->make()->each(function ($a) use ($event) {
            $a->name = $event['titleEvents'];
            $a->description = $event['description'];
            $a->link = $event['link'];
            $a->location = $event['location'];
            $a->start = $event['dateStart'];
            $a->end = $event['dateEnd'];


        	$keys = ['name', 'description'];
            $values = $a->only($keys);
           
           foreach ($keys as $key) {
           	 unset($a->$key);
           }

            $a->save();

            if ( !empty($event['imagePath']) )
                Image::make($event['imagePath'])->save( $a->coverFullPath() );

            foreach ($values as $key => $value) {
                $txt = new \App\TextField;
                $txt->object_type = $a->flag;
                $txt->object_id = $a->id;
                $txt->name = $key;
                $txt->value = $value;
                $txt->language_id = 1;
                $txt->save();
            }
        });
    }


    private $json = '{
    "events": [
    {
        "id": 0,
        "type": "EVENT",
        "imagePath": "https://travellingsommelier.files.wordpress.com/2010/03/art-vine-glasses.jpg",
        "titleEvents": "VINSKI MARATON",
        "datePublishing": "2018-02-18 12:20:20",
        "dateStart": "2018-09-22 08:00:00",
        "dateEnd": "2018-09-23 08:00:00",
        "location": "Palić",
        "link": "http://vinskimaraton.rs/",
        "description": "Vinska trka pružiće vam puno zabave i uživanja, ali zbog specifičnosti terena i vinskih degustacija, predstavlja slatki izazov i za najspremnije trkače. Namenjena je i profesionalnim sportistima i rekreativcima, uz naglasak na dobrom provodu učesnika.\nStaza Vinske trke je polumaratonska, dužine 21,1 km i prolazi kroz slikovite predele jezera Palić i okoline, kroz vinograde, pored vinarija, salaša… Na okrepnim stanicama vas pored vode i voća očekuju vrhunska vina i ukusni zalogaji. Trka predstavlja pravi trkački i gastronomski užitak!\nOno što ovu trku čini još zabavnijom je kostimiranje učesnika. Najbolji kostimi biće nagrađeni, a svi će doprineti karnevalskoj atmosferi manifestacije."
    },
    {
        "id": 1,
        "type": "EVENT",
        "imagePath": "",
        "titleEvents": "Glasajte za Srbiju #VoteForSerbija",
        "datePublishing": "2018-01-05 12:20:20",
        "dateStart": "2018-01-15 17:20:20",
        "dateEnd": "2018-01-20 17:20:20",
        "location": "Novi Sad, Trg Republike",
        "link": "http://www.vino.rs/podrum/zapisi-iz-podruma/item/2503-na-vinarskoj-slavi-u-trilogiji.html",
        "description": "Slava je u srpskoj tradiciji nešto veoma intimno, porodično. Na slavu se ne zove, na slavu se dolazi, iskreno i sa najvećim poštovanjem. Ali vinarska i narodna slava Sveti Trifun tu dopušta izvestan stepen kompromisa. Pogotovo danas."
    },{
        "id": 2,
        "type": "EVENT",
        "imagePath": "https://travellingsommelier.files.wordpress.com/2010/03/art-vine-glasses.jpg",
        "titleEvents": "Ev-2",
        "datePublishing": "2018-03-7 12:20:20",
        "dateStart": "2018-03-10 12:20:20",
        "dateEnd": "2018-03-11 20:20:20",
        "location": "Palić",
        "link": "http://vinskimaraton.rs/",
        "description": "Vinska trka pružiće vam puno zabave i uživanja, ali zbog specifičnosti terena i vinskih degustacija, predstavlja slatki izazov i za najspremnije trkače. Namenjena je i profesionalnim sportistima i rekreativcima, uz naglasak na dobrom provodu učesnika.\nStaza Vinske trke je polumaratonska, dužine 21,1 km i prolazi kroz slikovite predele jezera Palić i okoline, kroz vinograde, pored vinarija, salaša… Na okrepnim stanicama vas pored vode i voća očekuju vrhunska vina i ukusni zalogaji. Trka predstavlja pravi trkački i gastronomski užitak!\nOno što ovu trku čini još zabavnijom je kostimiranje učesnika. Najbolji kostimi biće nagrađeni, a svi će doprineti karnevalskoj atmosferi manifestacije."
    },
    {
        "id": 3,
        "type": "EVENT",
        "imagePath": "",
        "titleEvents": "Ev-3",
        "datePublishing": "2018-01-05 12:20:20",
        "dateStart": "2018-03-9 12:20:20",
        "dateEnd": "2018-03-20 20:20:20",
        "location": "Novi Sad, Trg Republike",
        "link": "http://www.vino.rs/podrum/zapisi-iz-podruma/item/2503-na-vinarskoj-slavi-u-trilogiji.html",
        "description": "Slava je u srpskoj tradiciji nešto veoma intimno, porodično. Na slavu se ne zove, na slavu se dolazi, iskreno i sa najvećim poštovanjem. Ali vinarska i narodna slava Sveti Trifun tu dopušta izvestan stepen kompromisa. Pogotovo danas."
    }]}';
}
