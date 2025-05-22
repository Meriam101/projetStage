<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    //
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_fin' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);
    
        $task = Task::create($request->all());
    
        return response()->json($task, 201);
    }

    public function markComplete($id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = true;
        $task->save();
    
        return response()->json($task);
    }
    
    public function destroy($id)
{
    $task = Task::findOrFail($id);
    $task->delete();
    return  request();
}

    

public function getTasks($id)
{
    $tasks = Task::where('user_id', $id)->get();
    return response()->json($tasks);
}



}
