<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_redirects_to_tasks(): void
    {
        $this->get('/')
            ->assertRedirect('/tasks');
    }

    public function test_task_pages_load(): void
    {
        $this->get('/tasks')
            ->assertOk()
            ->assertSee('My Task Board');

        $this->get('/tasks/create')
            ->assertOk()
            ->assertSee('Create New Task');
    }

    public function test_task_can_be_created(): void
    {
        $response = $this->post('/tasks', [
            'task_name' => 'Kyle Sample Task',
            'description' => 'Testing task creation.',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Kyle Sample Task',
            'status' => 'Pending',
        ]);
    }

    public function test_task_can_be_updated(): void
    {
        $task = Task::create([
            'task_name' => 'Old Task',
            'description' => 'Old description',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $this->put("/tasks/{$task->id}", [
            'task_name' => 'Updated Task',
            'description' => 'Updated description',
            'status' => 'Pending',
            'due_date' => '2026-10-01',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'task_name' => 'Updated Task',
        ]);
    }

    public function test_task_status_can_be_changed(): void
    {
        $task = Task::create([
            'task_name' => 'Status Test',
            'description' => null,
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $this->patch("/tasks/{$task->id}/status", [
            'status' => 'Completed',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Completed',
        ]);
    }

    public function test_task_can_be_deleted(): void
    {
        $task = Task::create([
            'task_name' => 'Delete Test',
            'description' => null,
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ]);

        $this->delete("/tasks/{$task->id}")
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_invalid_task_data_is_rejected(): void
    {
        $response = $this->post('/tasks', [
            'task_name' => '',
            'description' => '',
            'status' => 'Invalid',
            'due_date' => 'bad-date',
        ]);

        $response->assertSessionHasErrors([
            'task_name',
            'status',
            'due_date',
        ]);

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_missing_task_returns_404(): void
    {
        $this->get('/tasks/999/edit')
            ->assertNotFound();
    }
}
