<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::factory()
                ->count(20)
                ->sequence(fn (Sequence $sequence) => [
                    'id' => substr(uuid_create(), 0, -10) .
                        str_pad($sequence->index, 10, 0, STR_PAD_LEFT)]);

        User::factory()
            ->has($tasks)
            ->count(2)
            ->sequence(
                ['email' => 'test1@example.com'],
                ['email' => 'test2@example.com'],
            )
            ->create();
    }
}
