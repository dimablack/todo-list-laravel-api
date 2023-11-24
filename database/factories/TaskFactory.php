<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'priority' => fake()->numberBetween(1, 5),
            'title' => fake()->sentence(3),
            'description' => fake()->text(100),
        ];
    }
}
