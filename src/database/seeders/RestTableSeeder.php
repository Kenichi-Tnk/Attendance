<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Rest;

class RestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendances = Attendance::all();
        foreach ($attendances as $attendance) {
            // 1日1回休憩の例（必要に応じて複数回も可）
            Rest::create([
                'attendance_id' => $attendance->id,
                'rest_start' => '12:00',
                'rest_end' => '13:00',
            ]);
        }
    }
}
