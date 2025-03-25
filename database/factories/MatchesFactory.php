<?php

namespace Database\Factories;
use App\Models\Matches;
use App\Models\User;
use App\Models\Tournois;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matches>
 */
class MatchesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'date_match' => $this->faker->date,
            'user_id' => User::factory(), 
            'tournois_id' => Tournois::factory(),
        ];
    }
}
