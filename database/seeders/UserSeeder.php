<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(Task::factory()->count(3))
            ->count(2)
            ->sequence(
                ['email' => 'test1@example.com'],
                ['email' => 'test2@example.com'],
            )
            ->create();
    }
}
