<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 */
	public function run() : void {

		DB::table('patients')
		  ->truncate();

		$counter = 0;
		foreach ( $this->characterList() as $character ) {

			$counter++;
			if ( $counter < 9 ) {
				continue;
			}
			// because we truncate the table every time, the user IDs will be 2-10 for any staff.
			$created_by = User::where("role", "!=", UserRole::SuperAdmin->value)
							  ->inRandomOrder()
							  ->first();
			$created_by_id = $created_by->id;
			$created_at = fake()->dateTimeBetween($created_by->created_at, "-1 week");

			Patient::create([
				"status"        => "Active",
				"dob"           => fake()
					->dateTimeBetween("-100 years", "-1 year")
					->format("Y-m-d"),
				"gender"        => $character[ "gender" ],
				"first_name"    => $character[ "first_name" ],
				"last_name"     => $character[ "last_name" ],
				"email"         => str_replace(' ', '_',
					strtolower("{$character['first_name']}.{$character['last_name']}@example.com")),
				"password"      => bcrypt('password'),
				"created_by_id" => $created_by_id,
				"updated_by_id" => $created_by_id,
				"created_at"    => $created_at,
				"updated_at"    => $created_at,
			]);

		}
	}

	public function characterList() : array {

		$lines = array_map('trim', file(database_path("src/simpsons-characters.csv")));
		str_getcsv(array_shift($lines));

		$characters = array_map(function ( $line ) {
			$data = str_getcsv($line);
			return [
				'first_name' => $data[ 0 ] ?? '',
				'last_name'  => $data[ 1 ] ?? '',
				'gender'     => $data[ 2 ] ?? '',
			];
		}, $lines);

		return $characters;
	}
}
