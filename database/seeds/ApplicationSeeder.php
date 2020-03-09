<?php

use Illuminate\Database\Seeder;

use Intervention\Image\ImageManagerStatic as Image;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $articles = json_decode($this->json, 1);

        for ($i=0; $i < 5; $i++)
            foreach ($articles as $article)
                factory(\App\Article::class, 1)->make()->each(function ($a) use ($article) {
                    $a->name = $article['titleNews'];
                    $a->link = $article['link'];
                    $a->text = $article['description'];


              	    $keys = ['name', 'text'];
                    $values = $a->only($keys);
                   
                   foreach ($keys as $key) {
                   	 unset($a->$key);
                   }

                    $a->save();

                    if ( !empty($article['imagePath']) )
                        Image::make($article['imagePath'])->save( $a->coverFullPath() );

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

    private $json = '[
    {
        "type": "NEWS",
        "imagePath": "https://www.luxlife.rs/image.php/luksuz-vino-chianti-event%20(4).jpg?width=600&image=https://www.luxlife.rs/chest/gallery/ekskluzivni-dogadjaj-za-ljubitelje-vina/luksuz-vino-chianti-event%20(4).jpg",
        "titleNews": "Glasajte za Srbiju #VoteForSerbia",
        "datePublishing": "2018-01-10 17:20:20",
        "link": "http://www.vino.rs/podrum/zapisi-iz-podruma/item/2503-na-vinarskoj-slavi-u-trilogiji.html",
        "description": "Slava je u srpskoj tradiciji nešto veoma intimno, porodično. Na slavu se ne zove, na slavu se dolazi, iskreno i sa najvećim poštovanjem. Ali vinarska i narodna slava Sveti Trifun tu dopušta izvestan stepen kompromisa. Pogotovo danas."
    },
    {
        "type": "NEWS",
        "imagePath": "http://www.rts.rs/upload/storyBoxImageData/2017/10/06/23336776/Begef.jpg",
        "titleNews": "Otvoren vinski festival Begef 2017",
        "datePublishing": "2017-11-06 19:23:20",
        "link": "http://www.rts.rs/page/stories/sr/story/125/drustvo/2896203/otvoren-vinski-festival-begef-2017.html",
        "description": "Dvodnevni beogradski gastroenološki festival \"Begef 2017\", na kojem će biti predstavljeno oko 50 domaćih vinarija, otvoren je u Skupštini grada."
    },
    {
        "type": "NEWS",
        "imagePath": "https://www.luxlife.rs/image.php/luksuz-vino-chianti-event%20(4).jpg?width=600&image=https://www.luxlife.rs/chest/gallery/ekskluzivni-dogadjaj-za-ljubitelje-vina/luksuz-vino-chianti-event%20(4).jpg",
        "titleNews": "Festival Zemunski vinski trg u petak i subotu",
        "datePublishing": "2013-07-02 14:02:20",
        "link": "https://www.blic.rs/vesti/beograd/festival-zemunski-vinski-trg-u-petak-i-subotu/n3g6qc9",
        "description": "Više od 25 izlagača predstaviće se na vinsko-kulturološkom festivalu \"Zemunski vinski trg\", koji će biti održan 5. i 6. jula u centru Zemuna, na Velikom trgu pijaci, najavljeno je danas na konferenciji za novinare u Privrednoj komori Beograda (PKB)."
    }]';
}
