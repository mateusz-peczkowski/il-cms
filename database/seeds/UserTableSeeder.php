<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Mateusz Pęczkowski',
                'email' => 'mateusz@jampstudio.pl',
                'image' => Gravatar::src('mateusz@jampstudio.pl', ['width' => 250, 'height' => 250]),
                'role' => 4,
                'password' => Hash::make('test1234'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'Sławomir Kornacki',
                'email' => 'slawek@jampstudio.pl',
                'image' => Gravatar::src('slawek@jampstudio.pl', ['width' => 250, 'height' => 250]),
                'role' => 4,
                'password' => Hash::make('test1234'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
	}
}