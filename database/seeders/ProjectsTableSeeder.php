<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('projects')->insert([
            [
                'id' => 1,
                'name' => 'Proyecto Alpha',
                'user_id' => 1,
                'status' => 'active',
            ],
            [
                'id' => 2,
                'name' => 'Proyecto Omega',
                'user_id' => 1,
                'status' => 'active',
            ],
        ]);
    }
}
