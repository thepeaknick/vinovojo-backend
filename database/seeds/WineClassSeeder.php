<?php

use Illuminate\Database\Seeder;

class WineClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->sorts as $sort) {
        	$s = new \App\WineClass;
        	$s->save();

        	$txt = new \App\TextField;
        	$txt->name = 'name';
        	$txt->value = $sort;

        	$txt->object_id = $s->id;
        	$txt->object_type = $s->flag;

        	$txt->language_id = 1;

        	$txt->save();

            $txt = new \App\TextField;
            $txt->name = 'description';
            $txt->value = 'Opis sorte';

            $txt->object_id = $s->id;
            $txt->object_type = $s->flag;

            $txt->language_id = 1;

            $txt->save();
        }
    }

	private $sorts = [
		'Crno',
		'Belo',
		'Pinot noir',
		'Nebbiolo',
		'Rizvanac',
		'Traminac mirisni',
		'Chardonnay',
		'Zweigelt',
		'Tempranillo'
	];
}
