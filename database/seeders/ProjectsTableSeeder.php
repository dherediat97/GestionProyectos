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
                'user_id' => 3,
                'active' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Proyecto Omega',
                'user_id' => 3,
                'active' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Proyecto Vega',
                'user_id' => 2,
                'active' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Proyecto Centauri',
                'user_id' => 3,
                'active' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Proyecto Sirius',
                'user_id' => 2,
                'active' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Proyecto Andromeda',
                'user_id' => 2,
                'active' => 1,
            ],
        ]);
    }
}
