<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $text = fake()->randomElement(['Dormir 8 horas', 'Comer Sano', 'Lavar Ropa', 'Ejercicio']);
        return [
            'task_date' => fake()->date(),
            'text' => $text,
            'completed' => fake()->boolean(),
            'user_id' => User::factory()
        ];
    }
}
