<?php

use Illuminate\Database\Seeder;
use Sysproject\Client;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    	
        factory(Client::class, 20)->create();
    }
}
