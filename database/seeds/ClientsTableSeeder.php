<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = ['bavly' , 'kerolos' , 'omar' ];
        foreach ($clients as $client) {
            \App\Client::create([
                'name' => $client,
                'phone' => '0123456789',
                'address'=>'address'
            ]);
        }
    }
}
