<?php

use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->classes as $class) {
        	app('db')->table( app('App\WineClassification')->getTable() )->insert( $class );
        }
    }

    private $classes = [
    	[
    		// 'name' => 'ZELENO',
    		'name' => 'G.I.',
    		'colour' => '#c4d2bb',
            'description' => 'Vina od grožđa iz nekog od tri regiona: centralne Srbije, Vojvodine i Kosova, uz mogućnost korišćenja 15% grožđa nekog drugog regiona u zemlji.'
    	],
    	[
    		// 'name' => 'CRVENO',
    		'name' => 'K.P.K.',
    		'colour' => '#e4d3d6',
            'description' => 'Kvalitetna vina sa kontrolisanim geografskim poreklom i kvalitetomisključivo od grožđa iz jednog rejona ili vinogorja.'
    	],
    	[
    		// 'name' => 'LJUBIČASTA',
    		'name' => 'K.G.P.K.',
    		'colour' => '#ccc3d5',
            'description' => 'Vrhunska, najkvalitetnija vina iz jednog rejona ili vinogorja.'
    	]
    ];
}
