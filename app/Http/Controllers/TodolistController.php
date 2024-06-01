<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// import model
use App\Models\Task;

class TodolistController extends Controller
{
    //we will create for add, retrieve, edit and delete

    //retrieve
    public function retrieve(Request $request)
    {
        $userId = Auth::id();
        $tasks = Task::where('user_id', $userId)->get(['id', 'title', 'is_completed']);
        return view('dashboard', ['task' => $tasks]);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = $request->input('is_completed');
        $task->save();

        return response()->json(['message' => 'Task completion status updated successfully']);
    }

    // Method to update the task title
    public function updateTaskTitle(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->save();

        return response()->json(['message' => 'Task title updated successfully']);
    }

    //add
    public function add(Request $request, $id = false)
    {
        // Create a new task instance
        $task = new Task();
        $task->title = $request->input('task_title');
        $task->is_completed = 0;
        $task->user_id = Auth::id(); // Assign the authenticated user's ID

        // Save the task to the database
        $task->save();

        // Optionally, return a response or redirect
        return redirect()->route('dashboard')->with('success', 'Task added successfully');
    }

    //delete
    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully');
    }

}
