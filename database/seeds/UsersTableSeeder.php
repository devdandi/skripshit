<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'amir',
            'email' => 'amir@tes.com',
            'address' => 'Banjarmasin',
        	'password' => bcrypt('tes')
        ]);
    }
}
