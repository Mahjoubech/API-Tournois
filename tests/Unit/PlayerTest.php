<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Players;
use App\Models\User;
use App\Models\Tournois;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test
    
    public function test_index_returns_all_players()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    
        // Create a tournament
        $tournois = Tournois::factory()->create();
    
        // Create 3 players
        $players = Players::factory()->count(3)->create([
            'user_id' => $user->id,
            'tournois_id' => $tournois->id
        ]);
    
        // Send GET request to /api/players
        $response = $this->getJson('/api/players');
    
        // ✅ Check response status
        $response->assertStatus(200);
    
        // ✅ Ensure response contains 3 players
        $response->assertJsonCount(3);
    
        // ✅ Verify database contains the created players
        foreach ($players as $player) {
            $this->assertDatabaseHas('players', [
                'id' => $player->id,
                'name' => $player->name,
                'number' => $player->number,
                'user_id' => $player->user_id,
                'tournois_id' => $player->tournois_id
            ]);
        }
    }
    

    public function test_store_method_creates_a_new_player()
    {
        $user = User::factory()->create();
        $tournois = Tournois::factory()->create();
        $this->actingAs($user, 'api');

        $data = [
            'name' => 'Test Player',
            'number' => 10,
            'tournois_id' => $tournois->id
        ];
        $response = $this->postJson('/api/players', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('players', [
            'name' => 'Test Player',
            'number' => 10,
            'tournois_id' => $tournois->id,
            'user_id' => $user->id
        ]);
    }
}
