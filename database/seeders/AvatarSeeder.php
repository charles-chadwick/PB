<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvatarSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run (): void {

        DB::table('media')->truncate();

        // get the names of patients and users
        collect(User::all())
            ->merge(User::all())
            ->map(function ($model) {
                $this->addImage($model);
            });
    }

    private function addImage ($model) : void {

        $from_dir = database_path('src/avatars');

        // get the full name
        $name = [ $model->first_name ];
        if (isset($model->middle_name) && $model->middle_name != '') {
            $name[] = $model->middle_name;
        }
        $name[] = $model->last_name;

        $file_name = str_replace(' ', '_', implode('_', $name));

        $file_path = "$from_dir/$file_name.png";
        if (!\File::exists($file_path)) {
            echo "$file_path does not exist!\n";

            return;
        }

        $model->addMedia($file_path)
              ->preservingOriginal()
              ->toMediaCollection('avatars');

    }

}
