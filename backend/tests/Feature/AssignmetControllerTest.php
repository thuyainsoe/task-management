<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\AssignmentController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class AssignmetControllerTest extends TestCase
{
    use WithFaker;

    public function test_can_assign_to_user(): void
    {
        $this->login();

        $user = User::factory()->create();
        $task = Task::factory()->create();

        $args = [
            'task_id' => $task->id,
            'assigned_user_id' => $user->id,
        ];

        $request = new Request();
        $request->merge($args);

        $assignControll = new AssignmentController();

        $result = $assignControll->store($request);

        $this->assertDatabaseHas('assignments', $args);
    }

    public function test_can_set_start_and_due_date_when_creating_assignment(): void
    {
        $this->login();

        $user = User::factory()->create();
        $task = Task::factory()->create();

        $start_date = $this->faker()->date('Y-m-d H:i:s');
        $due_date = $this->faker()->date('Y-m-d H:i:s');

        $args = [
            'task_id' => $task->id,
            'assigned_user_id' => $user->id,
            'start_date' => $start_date,
            'due_date' => $due_date,
        ];

        $request = new Request();
        $request->merge($args);

        $assignControll = new AssignmentController();

        $result = $assignControll->store($request);

        $updated_task = $task->fresh();

        $this->assertEquals($start_date, $updated_task->start_date);
        $this->assertEquals($due_date, $updated_task->due_date);
    }
}
