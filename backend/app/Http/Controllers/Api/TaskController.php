<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskAssigned;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::get();
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
        return Task::create($data);
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
}
