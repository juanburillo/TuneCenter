<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'key' => fake()->randomElement([
                'C Major', 'C# Major',
                'D Major', 'D# Major',
                'E Major',
                'F Major', 'F# Major',
                'G Major', 'G# Major',
                'A Major', 'A# Major',
                'B Major'
            ]),
            'time_signature' => fake()->randomElement([
                '4/4',
                '6/8',
                '12/8',
            ]),
            'bpm' => fake()->numberBetween(60, 120),
        ];
    }
}
