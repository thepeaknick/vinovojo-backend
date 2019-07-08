<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $tableRow) {
            $table = $tableRow->Tables_in_predrag_vv;
            DB::table($table)->truncate();
        }

        $this->call('SocialSeeder');
        $this->call('UserSeeder');
        $this->call('LanguageSeeder');
        $this->call('ApplicationSeeder');
        $this->call('EventSeeder');
        $this->call('PathSeeder');
        $this->call('WineClassSeeder');
        $this->call('ClassificationSeeder');
        $this->call('AreaSeeder');
        $this->call('WineSeeder');
        // $this->call('POISeeder');
        // $this->call('WinerySeeder');
    }
}
