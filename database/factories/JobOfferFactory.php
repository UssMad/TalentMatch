<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobOfferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'required_skills' => ['PHP', 'Laravel', 'MySQL'],
            'min_experience' => fake()->numberBetween(1, 10),
        ];
    }
}
