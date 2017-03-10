<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PageTableSeeder extends Seeder {

	public function run()
	{
		DB::table('pages')->insert([
            ['id' => 1, 'name' => 'Home Page', 'url' => '/', 'order' => 1, 'tag' => 'homePage', 'controller' => '', 'view' => 'home', 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
	}
}