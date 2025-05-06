<?php
/** @noinspection ALL */

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Models\User;
use App\Models\Patient;
use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Str;

class AppointmentSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 */
	public function run() : void {

		DB::table("appointments")
		  ->delete();
		DB::table("appointments_users")
		  ->delete();

		$dialogue = $this->getCSV();

		foreach ( Patient::all() as $patient ) {

			// Start by getting the patients. Get a random number of appts for each pt.
			for ( $i = 0 ; $i <= rand(3, 25) ; $i++ ) {

				$start_date = Carbon::parse(fake()->dateTimeBetween($patient->created_at, "1 year"))
									->setHour(rand(8, 16))
									->setMinute(00)
									->setSecond(00)
									->toDateTimeString();

				$created_at = Carbon::parse($start_date)
									->subDays(rand(1, 30));

				$user = User::where("role", "!=", UserRole::SuperAdmin->value)
							->inRandomOrder()
							->first();

				// get the notes
				$dialogue_key = str_replace(' ', '_', strtolower($patient->first_name.'_'.$patient->last_name));
				if ( array_key_exists($dialogue_key, $dialogue) ) {
					$description = Arr::random($dialogue[ $dialogue_key ]);
					$title = Arr::random($dialogue[ $dialogue_key ]);
				}
				else {
					$description = Arr::random(Arr::random($dialogue));
					$title = Arr::random(Arr::random($dialogue));
				}

				$appointment = $patient->appointments()
									   ->create([
										   "patient_id"    => $patient->id,
										   "date_and_time" => $start_date,
										   "length"        => fake()->randomElement([
											   15,
											   30
										   ]),
										   "status"        => fake()->randomElement(AppointmentStatus::cases()),
										   "created_at"    => $created_at,
										   "updated_at"    => $created_at,
										   "created_by_id" => $user->id,
										   "updated_by_id" => $user->id,
										   "type"          => fake()->randomElement([
											   "House Call",
											   "In-Office",
											   "Video Visit"
										   ]),
										   "title"         => Str::of($title)
																 ->title()
																 ->limit(25),
										   "description"   => $description,
									   ]);

				DB::table("appointments_users")
				  ->insert([
					  "user_id"        => $user->id,
					  "appointment_id" => $appointment->id,
					  "created_at"     => $created_at,
					  "updated_at"     => $created_at,
					  "created_by_id"  => $user->id,
					  "updated_by_id"  => $user->id,
				  ]);
			}
		}
	}

	public function getCSV() {
		$filePath = base_path('database/src/simpsons_dataset.csv');
		$data = [];

		if ( file_exists($filePath) && is_readable($filePath) ) {
			$file = fopen($filePath, 'r');

			while ( ( $line = fgetcsv($file) ) !== false ) {
				// Skip blank lines
				if ( count($line) < 2 || empty(trim($line[ 0 ])) || empty(trim($line[ 1 ])) ) {
					continue;
				}

				$key = strtolower(str_replace(' ', '_', trim($line[ 0 ]))); // Generate the key
				$value = trim($line[ 1 ]);                                  // Generate the value

				if ( !array_key_exists($key, $data) ) {
					$data[ $key ] = [];
				}

				$data[ $key ][] = $value;
			}

			fclose($file);
		}

		return $data;


	}

}
