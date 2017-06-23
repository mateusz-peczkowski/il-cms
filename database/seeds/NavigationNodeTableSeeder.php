<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NavigationNodeTableSeeder extends Seeder {

	public function run()
	{
		DB::table('navigation_nodes')->insert([
            [
                'id' => 1,
                'title' => 'Strona główna',
                'navigation_id' => 1,
                'page_id' => 1,
                'parent_id' => null,
                'locale' => 'pl',
                'order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
	}
}