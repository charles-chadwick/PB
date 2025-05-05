<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Appointment;
use App\Models\Patient;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->word(),
            'status' => fake()->word(),
            'date_and_time' => fake()->dateTime(),
            'length' => fake()->numberBetween(-10000, 10000),
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'patient_id' => Patient::factory(),
        ];
    }
}
