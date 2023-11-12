<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\TaskController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_can_create_a_task(): void
    {
        $args = [
            'name' => $this->faker()->name,
            'description' => $this->faker()->paragraph,
            'start_date' => $this->faker()->date('Y-m-d H:i'),
            'due_date' => $this->faker()->date('Y-m-d H:i'),
        ];

        $request = new Request();
        $request->merge($args);

        $taskControl = new TaskController();
        $taskControl->store($request);

        $this->assertDatabaseHas('tasks', $args);
    }

    public function test_can_update_status_and_comment_for_update(): void
    {
        $this->login();
        $task = Task::factory()->create();

        $taskControl = new TaskController();

        $args = [
            'id' => $task->id,
            'status' => 'done',
            'comment' => $this->faker()->paragraph,
        ];

        $request = new Request();
        $request->merge($args);

        $taskControl->update($request, $task);

        $this->assertEquals('done', $task->status);
        $this->assertDatabaseHas('comments', ['description' => $args['comment']]);
    }

    /** @test */
    public function guest_cannot_fetch_tasks()
    {
        $response = $this->get('api/tasks', [
            'Accept' => 'application/json',
        ]);

        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    /** @test */
    public function authorized_user_can_fetch_tasks()
    {

        $email = 'mgmg@g.com';
        $authUser = User::factory(['email' => $email])->create();

        $token = $this->getToken();

        Task::factory(23)->create();

        $tasks = $this->get('api/tasks', [
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token",
        ]);

        $actualTasksCount = Task::count();

        $this->assertCount($actualTasksCount, $tasks->json());
    }
}
