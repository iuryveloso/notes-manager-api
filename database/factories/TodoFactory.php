<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => fake()->text(100),
            "body" => fake()->realText(500, 2),
            "color" => fake()->colorName(),
            "favorited" => fake()->boolean(),
        ];
    }
}
