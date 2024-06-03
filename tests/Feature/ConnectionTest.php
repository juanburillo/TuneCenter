<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConnectionTest extends TestCase
{
    use RefreshDatabase;

    private $senderUser;
    private $recipientUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->senderUser = User::factory()->create();
        $this->recipientUser = User::factory()->create();
    }

    public function test_connections_screen_can_be_rendered(): void
    {
        // When
        $response = $this->actingAs($this->senderUser)->get('/connections');

        // Then
        $response->assertStatus(200);
    }

    public function test_connection_request_can_be_sent(): void
    {
        // Given
        $recipientUserData = [
            'username' => $this->recipientUser->username,
        ];

        // When
        $response = $this->actingAs($this->senderUser)->post('/connections', $recipientUserData);

        // Then
        $response->assertRedirect(route('connections.index'));
        $this->assertDatabaseHas('connections', [
            'sender_id' => $this->senderUser->id,
            'recipient_id' => $this->recipientUser->id,
            'accepted' => false,
        ]);
    }
}
