<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()
            ->count(5)
            ->hasTasks(2)
            ->create();

        User::factory()
            ->count(1)
            ->hasTasks(10)
            ->create();

        DB::table('users')->insert([
            'name' => 'Andrés',
            'email' => 'andres@dev.com',
            'password' => bcrypt('test123')
        ]);
    }
}
