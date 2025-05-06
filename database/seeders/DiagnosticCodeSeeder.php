<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagnosticCodeSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 */
	public function run() : void {
		DB::table("diagnostic_codes")
		  ->delete();
		DB::table("patient_diagnostic_codes")
		  ->delete();

		$counter = 0;
		$codes = [];
		foreach ( $this->icd10List() as $icd10 ) {

			if ( $counter === 1000 ) {
				DB::table("diagnostic_codes")
				  ->insert($codes);
				$codes = [];
				$counter = 0;
				continue;
			}

			$codes[] = [
				'code'          => $icd10[ 'code' ],
				'description'   => $icd10[ 'description' ],
				'created_by_id' => 1
			];

			$counter++;

		}
	}

	public function icd10List() : array {
		$codes = array_map('trim', file(database_path("src/icd10cm_codes_2025.csv")));
		str_getcsv(array_shift($codes));

		return array_map(function ( $line ) {
			$data = str_getcsv($line);
			return [
				'code'        => $data[ 0 ] ?? '',
				'description' => $data[ 1 ] ?? ''
			];
		}, $codes);
	}
}
