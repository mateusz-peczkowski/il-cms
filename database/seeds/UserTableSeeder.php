<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->insert([
            ['id' => 1, 'name' => 'Mateusz Pęczkowski', 'email' => 'mateusz@jampstudio.pl', 'password' => Hash::make('test1234'), 'status' => 1, 'role' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
	}
}