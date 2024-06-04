<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Group;

class TaskController extends Controller
{

    public function retrieve(Request $request)
    {
        $userId = Auth::id();

        $taskNull = Task::where('user_id', $userId)
        ->whereNull('group_id')
        ->get(['id', 'title', 'is_completed','due_date', 'group_id']);
        $group = Group::where('user_id', $userId)->get(['id', 'title']);

        return view('dashboard', [
            'task' => $taskNull,
            'group' => $group
        ]);
    }

    public function create(Request $request, $id = false)
    {
        $task = new Task();
        $task->title = $request->input('task_title');
        $task->is_completed = 0;
        $task->due_date = $request->input('due_date') ?: null;
        $task->group_id = $request->input('group_id') ?: null;
        $task->user_id = Auth::id(); 
        $task->save();

        $groupId = $task->group_id;
        if ($groupId !== null) {
            return redirect()->back()->with('success', 'your message,here');   
        } else {
            return redirect()->route('dashboard')->with('success', 'Task added successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = $request->input('is_completed');
        $task->save();

        return response()->json(['success' => true]);
    }

    public function updateTaskTitle(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->save();

        return response()->json(['message' => 'Task title updated successfully']);
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);

        $groupId = $task->group_id;
        if ($groupId !== null) {
            $task->delete();
            return redirect()->back()->with('success', 'your message,here');   
        } else {
            $task->delete();
            return redirect()->route('dashboard')->with('success', 'Task added successfully');
        }
    }
}
