<?php

namespace Tests\Feature;

use App\Models\Tournois;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournoisTest extends TestCase
{
    use RefreshDatabase;
/** @test */
public function it_can_list_all_tournaments()
{
    // Create a new user (simulate authentication)
    $user = User::factory()->create();
    $this->actingAs($user, 'api'); // Authenticate the user

    // Create some tournaments
    $tournaments = Tournois::factory()->count(3)->create(['user_id' => $user->id]);

    // Send GET request to list tournaments
    $response = $this->getJson('/api/tournois');

    // Assert that the response is JSON and check the status code
    $response->assertStatus(200)
             ->assertJsonCount(3); // Check if the response has 3 tournaments

    // Assert that the tournaments are in the database
    foreach ($tournaments as $tournament) {
        $this->assertDatabaseHas('tournois', ['id' => $tournament->id]);
    }
}

    /** @test */
    public function it_can_create_a_tournament()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api'); // Authenticate the user

        // Define the tournament data
        $data = [
            'name' => 'Test Tournament',
            'description' => 'A test tournament',
            'start_date' => '2025-01-01',
            'end_date' => '2025-01-05',
        ];

        // Send POST request to store the tournament
        $response = $this->postJson('/api/tournois', $data);

        // Assert that the response is JSON and check the status code
        $response->assertStatus(201)
                 ->assertJson($data);

        // Assert that the tournament is in the database
        $this->assertDatabaseHas('tournois', $data);
    }
    /** @test */
public function it_can_update_a_tournament()
{
    $user = User::factory()->create();
    $this->actingAs($user, 'api'); // Authenticate the user

    $tournois = Tournois::factory()->create(['user_id' => $user->id]);

    $data = [
        'name' => 'Updated Tournament',
        'description' => 'Updated description',
        'start_date' => '2025-01-10',
        'end_date' => '2025-01-15',
    ];

    // Call the update method from the controller
    $response = $this->putJson("/api/tournois/{$tournois->id}", $data);

    $response->assertStatus(200)
             ->assertJson($data);

    $this->assertDatabaseHas('tournois', $data);
}
/** @test */
public function it_can_delete_a_tournament()
{
    $user = User::factory()->create();
    $this->actingAs($user, 'api'); // Authenticate the user

    $tournois = Tournois::factory()->create(['user_id' => $user->id]);

    // Call the destroy method from the controller
    $response = $this->deleteJson("/api/tournois/{$tournois->id}");

    $response->assertStatus(200)
             ->assertJson(['message' => 'The Country was deleted']);

    $this->assertDatabaseMissing('tournois', [
        'id' => $tournois->id,
    ]);
}

}
