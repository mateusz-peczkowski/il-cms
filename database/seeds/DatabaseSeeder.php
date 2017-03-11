<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		$this->call(PageTableSeeder::class);
		$this->command->info('Page table seeded!');

		$this->call(UserRolesTableSeeder::class);
		$this->command->info('User roles table seeded!');

        $this->call(UserTableSeeder::class);
        $this->command->info('User table seeded!');

		$this->call(LanguageTableSeeder::class);
		$this->command->info('Language table seeded!');
	}
}