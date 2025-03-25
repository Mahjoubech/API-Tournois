<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Players;
use App\Models\Matches;
use App\Models\User;
use App\Models\Tournois;
use Illuminate\Foundation\Testing\RefreshDatabase;
class MatchesTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test
    
    public function test_index_returns_all_matches()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $tournois = Tournois::factory()->create();
        $matches = Matches::factory()->count(3)->create([
            'user_id' => $user->id,
            'tournois_id' => $tournois->id
        ]);
        $response = $this->getJson('/api/matches');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
        foreach ($matches as $match) {
            $this->assertDatabaseHas('matches', [
               'date_match' => $match->date_match,
                'user_id' => $match->user_id,
                'tournois_id' => $match->tournois_id
            ]);
        }
    }
}
