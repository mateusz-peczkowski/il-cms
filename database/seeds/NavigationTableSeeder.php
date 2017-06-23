<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NavigationTableSeeder extends Seeder {

	public function run()
	{
		DB::table('navigations')->insert([
            [
                'id' => 1,
                'title' => 'Nawigacja główna',
                'slug' => 'nawigacja-glowna',
                'tag' => 'primary',
                'order' => 1,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
	}
}