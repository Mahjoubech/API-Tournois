<?php

namespace Database\Factories;
use App\Models\Matches;
use App\Models\Players;
use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player1_id' => Players::factory(),
            'player2_id' => Players::factory(),
            'match_id' => Matches::factory(),
            'player1_score' => $this->faker->numberBetween(0, 10),
            'player2_score' => $this->faker->numberBetween(0, 10),
            'user_id' => User::factory(), 
        ];
    }
}
