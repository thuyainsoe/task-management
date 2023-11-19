<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskAssigned;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::query();
        if($request->search) {
            
            $tasks_id = Task::where('name', 'like', "%$request->search%")
                            ->orWhere('description', 'like', "%$request->search%")
                            ->pluck('id')->toArray();
            
            $tasks_id_by_user = Assignment::whereIn('assigned_user_id', User::query()
                                ->where('name', 'like', "%$request->search%")
                                ->orWhereHas('department', function($department) use($request) {
                                    $department->where('name', 'like', "%$request->search%");
                                })
                                ->pluck('id'))
                            ->pluck('task_id')
                            ->toArray();

            $tasks_id = array_merge($tasks_id, $tasks_id_by_user);

            $tasks = $tasks->whereIn('id', $tasks_id);
        }

        if($request->user_id) {
            $tasks = $tasks->whereHas('assignment', function($assignment)use($request) {
                $assignment->where('assigned_user_id', $request->user_id);
            });
        }

        if($request->department_id) {
            $user_ids = User::where('department_id', $request->department_id)->pluck('id');
            $tasks = $tasks->whereHas('assignment', function($assignment) use($user_ids) {
                $assignment->whereIn('assigned_user_id', $user_ids);
            });
        }

        if($request->status) {
            $tasks = $tasks->where('status', $request->status);
        }

        if($request->priority) {
            $tasks = $tasks->where('priority', $request->priority);
        }

        return $tasks->with('tags', 'assignment.assignedUser.department', 'assignment.assignedBy.department')->orderByDesc('updated_at')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->toArray();
        $task = Task::create($data);

        if($request->assigned_user_id) {
            $request['task_id'] = $task->id;
            $assignControl = new AssignmentController();

            $assignControl->store($request);
        }

        if($request->tags) {
            $task->tags()->sync($request->tags);
        }

        return $task;
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task = Task::find($request->id);
        $data = $request->toArray();

        $task->update($data);

        if($request->comment) {
            $comment = [
                'task_id' => $task->id,
                'description' => $data['comment'],
            ];

            Comment::create($comment);
        }

        if ($request->has('tags')) {
            if (count($request->tags) > 0) {
                $task->tags()->sync($request->tags);
            } else {
                $task->tags()->detach();
            }
        }

        $user = auth()->user();
        $date = Carbon::now()->format('Y-m-d H:i');

        $notification = [
            'message' => "$user->name updated '$task->name' at $date",
        ];

        Notification::create($notification);

        event(new TaskAssigned($user));

        return $task;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function getComment(Request $request) {
        return Comment::query()->where('task_id', $request->task_id)->orderByDesc('created_at')->get();
    }
}
