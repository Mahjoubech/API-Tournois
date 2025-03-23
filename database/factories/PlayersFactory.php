<?php

namespace Database\Factories;

use App\Models\Players;
use App\Models\User;
use App\Models\Tournois;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Players>
 */
class PlayersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber(2),
            'user_id' => User::factory(), 
            'tournois_id' => Tournois::factory(),
        ];
    }
}
