<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 */
	public function run() : void {
		( new UserSeeder() )->run();
		( new PatientSeeder() )->run();
		( new DiagnosticCodeSeeder() )->run();
		( new AppointmentSeeder() )->run();
		( new AvatarSeeder())->run();
	}


	public static function characterList() : array {

		$lines = array_map('trim', file(database_path("src/simpsons-characters.csv")));
		str_getcsv(array_shift($lines));

		return array_map(function ( $line ) {
			$data = str_getcsv($line);
			return [
				'first_name'  => $data[ 0 ] ?? '',
				'middle_name' => $data[ 1 ] ?? '',
				'last_name'   => $data[ 2 ] ?? '',
				'gender'      => $data[ 3 ] ?? '',
				'avatar'      => $data[ 4 ] ?? '',
			];
		}, $lines);
	}
}
