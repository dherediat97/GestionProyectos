<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
     /**
      * Run the database seeds.
      */
     public function run()
     {
          DB::table('events')->insert([
               [
                    'text' => 'Tarea #1',
                    'start_date' => '2025-05-04 08:00:00',
                    'end_date' => '2025-05-05 12:00:00',
                    'project_id' => 1,
                    'user_id' => 2,
               ],
               [
                    'text' => 'Tarea #2',
                    'start_date' => '2025-05-05 15:00:00',
                    'end_date' => '2025-05-06 16:30:00',
                    'project_id' => 1,
                    'user_id' => 2,
               ],
               [
                    'text' => 'Tarea #3',
                    'start_date' => '2025-05-06 00:00:00',
                    'end_date' => '2025-05-07 00:00:00',
                    'project_id' => 2,
                    'user_id' => 3,
               ],
               [
                    'text' => 'Tarea #4',
                    'start_date' => '2025-05-07 08:00:00',
                    'end_date' => '2025-05-08 12:00:00',
                    'project_id' => 2,
                    'user_id' => 3,
               ],
               [
                    'text' => 'Tarea #5',
                    'start_date' => '2025-05-08 08:00:00',
                    'end_date' => '2025-05-09 12:00:00',
                    'project_id' => 2,
                    'user_id' => 3,
               ],
               [
                    'text' => 'Tarea #6',
                    'start_date' => '2025-05-10 08:00:00',
                    'end_date' => '2025-05-11 12:00:00',
                    'project_id' => 3,
                    'user_id' => 3,
               ]
          ]);
     }
}
