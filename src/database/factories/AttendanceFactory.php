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
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => $this->faker->date('Y-m-d', '2025-05-31'),
            'clock_in' => '09:00',
            'clock_out' => '18:00',
            // rest_timeやtotal_timeは不要（別テーブル管理の場合）
        ];
    }
}
