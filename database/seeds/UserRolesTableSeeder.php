<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserRolesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('user_roles')->insert([
            ['id' => 1,
                'title' => 'moderator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            ['id' => 2,
                'title' => 'developer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            ['id' => 3,
                'title' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            ['id' => 4,
                'title' => 'superadmin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
	}
}