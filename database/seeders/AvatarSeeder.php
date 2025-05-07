<?php

namespace Database\Seeders;

use AllowDynamicProperties;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

#[AllowDynamicProperties] class AvatarSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run (): void {

        DB::table('media')->truncate();

        // get the names of patients and users
		$characters = collect(DatabaseSeeder::characterList());
		collect(User::all())
            ->merge(Patient::all())
            ->map(function ($model) use ($characters) {
				$from_dir = database_path('src/avatars');

				// get the full name
				$name = [ $model->first_name ];
				if (isset($model->middle_name) && $model->middle_name != '') {
					$name[] = $model->middle_name;
				}
				$name[] = $model->last_name;

				$file_name = $characters->where('first_name', $name[ 0 ])->where('last_name', $name[ 1 ])->first();
				if ( !isset($file_name['avatar']) ) {
					return;
				}

				$file_name = $file_name['avatar'];

				$file_path = "$from_dir/$file_name";
				if (!\File::exists($file_path)) {
					echo "$file_path does not exist!\n";

					return;
				}

				$model->addMedia($file_path)
					  ->preservingOriginal()
					  ->toMediaCollection('avatars');
            });
    }

}
