<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Index tasks
     */
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->get();

        return response()->json([
            'success' => true,
            'message' => 'Tasks retrieved successfully',
            'data' => $tasks,
        ], 200);
    }

    /**
     * Store new Task
     */
    public function store(Request $request)
    {
        $userId = $request->user()->id;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date',
        ]);

        $validated['user_id'] = $userId;

        $task = $request->user()->tasks()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'data' => $task
        ], 201);
    }

    /**
     * Show Task
     */
    public function show(Request $request, Task $task)
    {
        if($request->user()->id !== $task->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task retrieved successfully',
            'data' => $task
        ], 200);
    }

    /**
     * Update Task
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ((int) $request->user()->id !== (int) $task->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string|max:255',
        'status' => 'sometimes|in:pending,in_progress,completed',
        'due_date' => 'sometimes|date',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Task retrieved successfully',
            'data' => $task->toArray()
        ], 200);
    }

    /**
     * Delete Task
     */
    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if((int) $request->user()->id !== (int) $task->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ], 200);
    }
}
