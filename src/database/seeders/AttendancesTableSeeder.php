<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. テストユーザーの作成
        $users = [
            ['name' => 'テスト一郎', 'email' => 'ichiro@test.com', 'password' => bcrypt('password')],
            ['name' => 'テスト二郎', 'email' => 'jiro@test.com', 'password' => bcrypt('password')],
            ['name' => 'テスト三郎', 'email' => 'saburo@test.com', 'password' => bcrypt('password')],
            ['name' => 'テスト四郎', 'email' => 'shiro@test.com', 'password' => bcrypt('password')],
            ['name' => 'テスト五郎', 'email' => 'goro@test.com', 'password' => bcrypt('password')],
            ['name' => 'テスト六郎', 'email' => 'rokuro@test.com', 'password' => bcrypt('password')],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // 2. 勤怠データの作成
        $startOfMonth = Carbon::create(2024, 12, 1);
        $endOfMonth = Carbon::create(2024, 12, 31);
        $users = User::all();

        foreach ($users as $user) {
            $currentDate = $startOfMonth;

            while ($currentDate->lte($endOfMonth)) {
                $attendance = Attendance::create([
                    'user_id' => $user->id,
                    'date' => $currentDate->toDateString(),
                    'start_work' => $currentDate->copy()->hour(9)->minute(0),
                    'end_work' => $currentDate->copy()->hour(17)->minute(0),
                ]);

                // 休憩データを作成
                Rest::create([
                    'attendance_id' => $attendance->id,
                    'start_rest' => $currentDate->copy()->hour(12)->minute(0),
                    'end_rest' => $currentDate->copy()->hour(12)->minute(45),
                ]);

                $currentDate->addDay();
            }
        }
    }
}
