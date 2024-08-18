<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'first_name'=>'bavly',
            'last_name'=>'eskander',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('12345678')
        ]);
        $user->attachRole('super_admin');
    }
}
