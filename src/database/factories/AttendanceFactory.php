<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Attendance;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, //既存ユーザーからランダムに選択
            'date' => $this->faker->date(),
            'clock_in' => $this->faker->time('H:i:s'),
            'clock_out' => $this->faker->time('H:i:s'),
        ];
    }
}
