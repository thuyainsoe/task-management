<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskAssigned;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $data['assigned_by'] = auth()->id();

        $assignment = Assignment::create($data);

        $assignment->task->updateWhenAssigned($data);

        $assigned_by = auth()->user()->name;
        $assigned_user_name = $assignment->assignedUser->name;
        $task_name = $assignment->task->name;
        $notification = [
            'user_id' => $assignment->assigned_user_id,
            'message' => "$assigned_by assigned $assigned_user_name task '$task_name'",
        ];

        Notification::create($notification);

        event(new TaskAssigned($assignment->assignedUser));

        return $assignment;

    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
