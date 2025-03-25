<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Players;
use App\Models\Matches;
use App\Models\User;
use App\Models\Tournois;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{
    use RefreshDatabase; // Resets the database before each test
    
    public function test_index_returns_all_players()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $tournois = Tournois::factory()->create();
        $players = Players::factory()->count(3)->create([
            'user_id' => $user->id,
            'tournois_id' => $tournois->id
        ]);
        $response = $this->getJson('/api/players');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
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
    public function test_Edit_method_Update_a_player()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $tournois = Tournois::factory()->create();
        $player = Players::factory()->create([
            'user_id' => $user->id,
            'tournois_id' => $tournois->id,
        ]);
        $data = [
            'name' => 'Test hhh Player',
            'number' => 12,
        ];
        $response = $this->putJson(route('players.update', $player->id), $data);
        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Test hhh Player',
                     'number' => 12,
                     'user_id' => $user->id,
                     'tournois_id' => $tournois->id,
                 ]);
        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'name' => 'Test hhh Player',
            'number' => 12,
            'user_id' => $user->id,
            'tournois_id' => $tournois->id,
        ]);
    }
    public function test_delete_methode_destory_player(){
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $tournois = Tournois::factory()->create();
        $player = Players::factory()->create([
            'user_id'=> $user->id,
            'tournois_id' => $tournois->id,
        ]);
        $response = $this->deleteJson(route('players.destroy', $player->id));
        $response->assertStatus(200) ->assertJson(['message' => 'The Player was deleted']);
        $this->assertDatabaseMissing('players',[
            'id' => $player->id,
        ]);

    }
    public function test_get_player_returns_specific_player()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $tournois = Tournois::factory()->create();
        $player = Players::factory()->create([
            'user_id' => $user->id,
            'tournois_id' => $tournois->id,
        ]);

        $response = $this->getJson(route('players.show', $player->id));
        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $player->id,
                     'name' => $player->name,
                     'number' => $player->number,
                     'tournois_id' => $player->tournois_id,
                     'user_id' => $player->user_id
                 ]);
    }
    public function test_assign_player_to_match()
{
    $user = User::factory()->create();
    $this->actingAs($user, 'api');
    $tournois = Tournois::factory()->create();
    $player = Players::factory()->create([
        'user_id' => $user->id,
        'tournois_id' => $tournois->id,
    ]);
    $match = Matches::factory()->create([
        'tournois_id' => $tournois->id,
    ]);
    $data = ['match_id' => $match->id];
    $response = $this->postJson("/api/players/{$player->id}/assign-match", $data);

    $response->assertStatus(200)
             ->assertJson(['message' => 'Player assigned to match successfully']);
    $this->assertDatabaseHas('match_player', [
        'player_id' => $player->id,
        'match_id' => $match->id,
    ]);
    $response = $this->postJson("/api/players/{$player->id}/assign-match", $data);
    $response->assertStatus(400)
             ->assertJson(['message' => 'Player already assigned to this match']);
}
public function test_remove_player_from_match()
{
    $user = User::factory()->create();
    $this->actingAs($user, 'api'); 
    $tournois = Tournois::factory()->create();
    $player = Players::factory()->create([
        'user_id' => $user->id,
        'tournois_id' => $tournois->id,
    ]);
    $match = Matches::factory()->create([
        'tournois_id' => $tournois->id,
    ]);
    $player->matches()->attach($match->id);  
    $this->assertDatabaseHas('match_player', [
        'player_id' => $player->id,
        'match_id' => $match->id,
    ]);
    $response = $this->postJson("/api/players/{$player->id}/remove-from-match/{$match->id}");
   $response->assertStatus(200)
             ->assertJson(['message' => 'Player removed from match successfully']);
    $this->assertDatabaseMissing('match_player', [
        'player_id' => $player->id,
        'match_id' => $match->id,
    ]);
}


}
