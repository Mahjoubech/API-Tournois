<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test


    public function test_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Jcherkaoui',
            'email' => 'ch@example.com',
            'password' => '12301230',
            'password_confirmation' => '12301230',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'User registered successfully']);

        $this->assertDatabaseHas('users', [
            'email' => 'ch@example.com',
        ]);
    }


    public function test_login()
    {
        $user = User::create([
            'name' => 'Jcherkaoui',
            'email' => 'ch@example.com',
            'password' => Hash::make('12301230'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'ch@example.com',
            'password' => '12301230',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token']);
    }


    public function test_logout()
    {
        $user = User::create([
            'name' => 'Jcherkaoui',
            'email' => 'ch@example.com',
            'password' => Hash::make('12301230'),
        ]);

        // Generate a JWT token
        $token = JWTAuth::fromUser($user);

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'User logged out successfully']);
    }


    public function test_user()
    {
        $user = User::create([
            'name' => 'Jcherkaoui',
            'email' => 'ch@example.com',
            'password' => Hash::make('12301230'),
        ]);

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        $response = $this->getJson('/api/user', [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertStatus(200)
                 ->assertJson(['email' => 'ch@example.com']);
    }
}
