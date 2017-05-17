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
                'email' => 'mateusz.peczkowski@insanelab.com',
                'image' => Gravatar::src('mateusz.peczkowski@insanelab.com', ['width' => 250, 'height' => 250]),
                'role' => 4,
                'password' => Hash::make('test1234'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'id' => 2,
                'name' => 'Tomasz urban',
                'email' => 'tomek.urban@insanelab.com',
                'image' => Gravatar::src('tomek.urban@insanelab.com', ['width' => 250, 'height' => 250]),
                'role' => 4,
                'password' => Hash::make('test1234'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
	}
}