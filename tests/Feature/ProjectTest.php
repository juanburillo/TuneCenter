<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_projects_screen_can_be_rendered(): void
    {
        // When
        $response = $this->actingAs($this->user)->get('/projects');

        // Then
        $response->assertStatus(200);
    }

    public function test_specific_project_screen_can_be_rendered(): void
    {
        // Given
        $project = Project::factory()->create(['owner_id' => $this->user->id]);

        // When
        $response = $this->actingAs($this->user)->get('/projects/'.$project->id);

        // Then
        $response->assertStatus(200);
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
        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'key' => 'C Major',
            'time_signature' => '4/4',
            'bpm' => 120,
            'is_collaborative' => false,
            'owner_id' => $this->user->id,
        ]);
    }

    public function test_project_info_can_be_updated(): void
    {
        // Given
        $project = Project::factory()->create(['owner_id' => $this->user->id]);

        $newProjectData = [
            'title' => 'Test Project',
            'key' => 'C Minor',
            'time_signature' => '3/4',
            'bpm' => 180,
        ];

        // When
        $response = $this->actingAs($this->user)->put('/projects/'.$project->id, $newProjectData);

        // Then
        $response->assertStatus(200);
        $this->assertDatabaseHas('projects', $newProjectData);
    }

    public function test_projects_can_be_deleted(): void
    {
        // Given
        $project = Project::factory()->create(['owner_id' => $this->user->id]);

        // When
        $response = $this->actingAs($this->user)->delete('/projects/'.$project->id);

        // Then
        $response->assertStatus(200);
        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    public function test_project_is_deleted_if_owner_is_deleted(): void
    {
        // Given
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        // When
        $user->delete();

        // Then
        $this->assertDatabaseMissing('projects', $project->toArray());
    }
}
