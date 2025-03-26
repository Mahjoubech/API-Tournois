<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Matches;
use App\Models\Players;
use App\Models\Tournois;
use App\Models\Score;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_get_all_scores()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $tournois = Tournois::factory()->create(
            ['user_id' => $user->id]
        );
        $matches = Matches::factory()->create(
            ['user_id' => $user->id, 'tournois_id' => $tournois->id]
        ); 
        $playerOne = Players::factory()->create(
            ['name' => 'Player One','user_id' => $user->id, 'tournois_id' => $tournois->id]
        );
        $playerTwo = Players::factory()->create(['name' => 'Player Two','user_id' => $user->id, 'tournois_id' => $tournois->id]
    );
            Score::create([
            'player1_id' => $playerOne->id,
            'player2_id' => $playerTwo->id,
            'match_id' => $matches->id,
            'player1_score' => 3,
            'player2_score' => 2,
            'user_id' => $user->id 
        ]);
        $response = $this->json('GET', '/api/score');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'match_id' => $matches->id,
            'score' => 'Player One 3 - 2 Player Two'
        ]);
    }
    public function test_store_a_new_scores()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $tournois = Tournois::factory()->create(['user_id' => $user->id]);
        $match = Matches::factory()->create(['user_id' => $user->id, 'tournois_id' => $tournois->id]);
        $playerOne = Players::factory()->create(['user_id' => $user->id, 'tournois_id' => $tournois->id]);
        $playerTwo = Players::factory()->create(['user_id' => $user->id, 'tournois_id' => $tournois->id]);
        $response = $this->json('POST', '/api/score', [
            'player1_id' => $playerOne->id,
            'player2_id' => $playerTwo->id,
            'match_id' => $match->id,
            'player1_score' => 3,
            'player2_score' => 2,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('scores', [
            'player1_id' => $playerOne->id,
            'player2_id' => $playerTwo->id,
            'match_id' => $match->id,
            'player1_score' => 3,
            'player2_score' => 2,
            'user_id' => $user->id, 
        ]);

        $response->assertJson([
            'player1_id' => $playerOne->id,
            'player2_id' => $playerTwo->id,
            'match_id' => $match->id,
            'player1_score' => 3,
            'player2_score' => 2,
            'user_id' => $user->id,
        ]);
    }

}
