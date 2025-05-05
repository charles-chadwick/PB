<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ICD10Code;

class ICD10CodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ICD10Code::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => fake()->word(),
            'description' => fake()->text(),
        ];
    }
}
