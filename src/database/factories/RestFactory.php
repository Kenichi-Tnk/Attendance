<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    { $factory->define(App\Models\Rest::class, function (Faker\Generator $faker) {
            return [
                'attendance_id' => Attendance::inRandomOrder()->first()->id,
                'rest_start' => '12:00',
                'rest_end' => '13:00',
            ];
        });
    }
}
