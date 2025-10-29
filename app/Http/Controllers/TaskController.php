<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    return response()->json($request->user()->tasks()->latest()->get());
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
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task = $request->user()->tasks()->create($request->only('title', 'description'));
    return response()->json($task, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
{
    $task = $request->user()->tasks()->find($id);

    if (!$task) {
        return response()->json(['message' => 'Task not found'], 404);
    }

    return response()->json($task, 200);
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
    public function update(Request $request, $id)
    {
        $task = $request->user()->tasks()->find($id);

        if (!$task) return response()->json(['message' => 'Task not found'], 404);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $task->update($request->only('title', 'description', 'is_completed'));

        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
{
    $task = $request->user()->tasks()->find($id);

    if (!$task) {
        return response()->json(['message' => 'Task not found'], 404);
    }

    $task->delete();

    return response()->json(['message' => 'Task deleted successfully'], 200);
}


public function completed(Request $request)
    {
        $tasks = $request->user()->tasks()->where('is_completed', true)->get();

        return response()->json($tasks, 200);
    }



   public function pending(Request $request)
{
    $tasks = $request->user()->tasks()->where('is_completed', false)->get();

    return response()->json($tasks, 200);
}

public function toggle($id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['message' => 'Task not found'], 404);
    }

    $task->is_completed = !$task->is_completed;
    $task->save();

    return response()->json([
        'message' => 'Task status toggled successfully',
        'task' => $task
    ], 200);
}


}
