<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('123456789'),
                'is_user_admin' => true,
            ],
            [
                'id' => 2,
                'name' => 'David',
                'email' => 'david@example.com',
                'password' => bcrypt('123456789'),
                'is_user_admin' => false,
            ],
            [
                'id' => 3,
                'name' => 'Juan',
                'email' => 'juan@example.com',
                'password' => bcrypt('123456789'),
                'is_user_admin' => false,
            ]
        ]);
    }
}
