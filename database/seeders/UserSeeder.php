<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 */
	public function run() : void {

		DB::table('users')
		  ->truncate();

		User::create([
			"role"          => UserRole::SuperAdmin,
			"first_name"    => "John",
			"last_name"     => "Doe",
			"email"         => "john.doe@example.com",
			"password"      => bcrypt('password'),
			"created_by_id" => 1,
			"created_at"    => "2020-01-01 08:00:00",
		]);

		$counter = 0;
		foreach ( DatabaseSeeder::characterList() as $character ) {
			$email = str_replace(' ', '_',
				strtolower("{$character['first_name']}.{$character['last_name']}@example.com"));

			$role = match ( true ) {
				$counter <= 1 => UserRole::Doctor,
				$counter <= 4 => UserRole::Nurse,
				default       => UserRole::Staff
			};

			// because we truncate the table every time, the user IDs will be 2-10 for any staff.
			$created_by_id = 1;
			$created_at = fake()->dateTimeBetween("2020-01-01 08:00:00", "2021-01-01 08:00:00");

			$user = User::create([
				"role"          => $role,
				"first_name"    => $character[ "first_name" ],
				"last_name"     => $character[ "last_name" ],
				"email"         => $email,
				"password"      => bcrypt('password'),
				"created_by_id" => $created_by_id,
				"updated_by_id" => $created_by_id,
				"created_at"    => $created_at,
				"updated_at"    => $created_at,
			]);
		}
	}
}
