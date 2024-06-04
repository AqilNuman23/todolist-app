<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\Task;

class GroupController extends Controller
{
    public function show(Request $request, $id)
    {
        $groupId = $id;
        $group = Group::findOrFail($request->input('group_id'));
        $userId = Auth::id();
        
        $taskwGroup = Task::where('user_id', $userId)
        ->where('group_id', $groupId)
        ->get(['id', 'title', 'is_completed', 'group_id']);
        
        return view('group', compact('group', 'taskwGroup'));
    }

    public function create(Request $request, $id = false)
    {
        $group = new Group();
        $group->title = $request->input('group_title');
        $group->user_id = Auth::id(); 
        $group->save();

        return redirect()->route('dashboard')->with('success', 'Group added successfully');
    }

    public function updateGroupTitle(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $group->title = $request->input('group_title');
        $group->save();

        return response()->json(['message' => 'Group title updated successfully']);
    }

    public function delete($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('dashboard')->with('success', 'Group deleted successfully');
    }
}
