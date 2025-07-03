<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('is_admin', false)->get();

        foreach ($users as $user) {
            // 4月分
            $days = range(1, 30); // 1日から30日まで
            shuffle($days); // 日付をランダムに並べ替え
            $holidays = array_slice($days, 0, 8); // 8日を休日として選択
            for ($day = 1; $day <= 30; $day++) {
                if (in_array($day, $holidays)) {
                    continue; // この日は休み（データ作成しない）
                }
                $date = "2025-04-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                Attendance::firstOrCreate([
                    'user_id' => $user->id,
                    'date' => $date,
                ], [
                    'clock_in' => '9:00',
                    'clock_out' => '18:00',
                ]);
            }

            // 5月分も同様に
            $days = range(1, 31); // 1日から31日まで
            shuffle($days); // 日付をランダムに並べ替え
            $holidays = array_slice($days, 0, 8); // 8
            for ($day = 1; $day <= 31; $day++) {
                if (in_array($day, $holidays)) {
                    continue; // この日は休み（データ作成しない）
                }
                $date = "2025-05-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                Attendance::firstOrCreate([
                    'user_id' => $user->id,
                    'date' => $date,
                ], [
                    'clock_in' => '9:00',
                    'clock_out' => '18:00',
                ]);
            }
        }
    }
}
