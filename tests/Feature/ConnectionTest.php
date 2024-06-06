<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->actingAs($this->senderUser)->post('/connections', $recipientUserData);

        // Then
        $this->assertDatabaseHas('connections', [
            'sender_id' => $this->senderUser->id,
            'recipient_id' => $this->recipientUser->id,
            'accepted' => false,
        ]);
    }

    public function test_connection_request_can_be_declined(): void
    {
        // Given
        $recipientUserData = [
            'username' => $this->recipientUser->username,
        ];

        $this->actingAs($this->senderUser)->post('/connections', $recipientUserData);

        // When
        $this->actingAs($this->recipientUser)->put('/connections/'.$this->senderUser->id);

        // Then
        $this->assertDatabaseHas('connections', [
            'sender_id' => $this->senderUser->id,
            'recipient_id' => $this->recipientUser->id,
            'accepted' => true,
        ]);
    }

    public function test_connection_can_be_deleted(): void
    {
        // Given
        $recipientUserData = [
            'username' => $this->recipientUser->username,
        ];

        $this->actingAs($this->senderUser)->post('/connections', $recipientUserData);

        // When
        $this->actingAs($this->recipientUser)->delete('/connections/'.$this->senderUser->id);

        // Then
        $this->assertDatabaseMissing('connections', [
            'sender_id' => $this->senderUser->id,
            'recipient_id' => $this->recipientUser->id,
            'accepted' => false,
        ]);
    }
}
