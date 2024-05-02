<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_projects_can_be_created(): void
    {
        // Given
        $projectData = [
            'title' => 'Test Project',
        ];

        // When
        $response = $this->actingAs($this->user)->post('/projects', $projectData);

        // Then
        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'key' => 'C Major',
            'time_signature' => '4/4',
            'bpm' => 120,
            'is_collaborative' => false
        ]);
    }
}
