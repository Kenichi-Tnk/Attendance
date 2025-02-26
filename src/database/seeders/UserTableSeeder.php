<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 一般ユーザーを10人作成
        User::factory()->count(10)->create();

        // 一般ユーザーのテストユーザーを1人作成
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'), // パスワードを固定
        ]);

        // 管理者ユーザーを1人作成
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // パスワードを固定
        ]);
    }
}
