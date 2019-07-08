<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new \App\User;
        $u->full_name = 'Misa Kovic';
        $u->email = 'misa@gmail.com';
        $u->password = '123';
        $u->type = 'admin';
        $u->save();
    }
}
