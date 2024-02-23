<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;


class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $user = User::where('email', "andres@dev.com")->first(); // test user of the app

        // Daily Records with and without completed
        DB::table('tasks')->insert([
            'task_date' => date('Y-m-d'),
            'text' => 'Estudiar',
            'completed' => false,
            'user_id' => $user->id
        ]);

        DB::table('tasks')->insert([
            'task_date' => date('Y-m-d H:i:s'),
            'text' => 'Estudiar 2',
            'completed' => true,
            'user_id' => $user->id
        ]);
    }
}
