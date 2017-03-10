<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LanguageTableSeeder extends Seeder {

	public function run()
	{
		DB::table('languages')->insert([
            ['id' => 1, 'title' => 'Polski', 'slug' => 'pl', 'is_default' => 1, 'status' => 1, 'order' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
	}
}