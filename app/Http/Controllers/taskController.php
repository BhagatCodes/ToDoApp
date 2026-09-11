<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class taskController extends Controller
{
    function addTask(Request $request){
        $request->validate([
            'category_id'=>'required|exists:categories,id',
            'task_title' => 'required|min:3|max:200',
            'task_description' => 'nullable|string|max:500',
            'task_start' => 'required|date',
            'working_hours' => 'required|integer|min:0'
        ]);
        $results = Task::create([
            'category_id' => $request->category_id,
            'task_title' => $request->task_title,
            'task_description' => $request->task_description,
            'task_start' => $request->task_start,
            'working_hours' => $request->working_hours,
            'session_id'=>session()->id(),
        ]);
        return redirect('/');
    }
    public function index()
    {
        $tasks = Task::with('category')->get();

        return view('welcome', compact('tasks'));
    }
    public function editTask(Request $request){
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'category_id' => 'required|exists:categories,id',
            'task_title' => 'required|min:3|max:200',
            'task_description' => 'nullable|string|max:500',
            'task_start' => 'required|date',
            'working_hours' => 'required|integer|min:0'
        ]);

        $task = Task::findOrFail($request->task_id);
        $task->update([
            'category_id' => $request->category_id,
            'task_title' => $request->task_title,
            'task_description' => $request->task_description,
            'task_start' => $request->task_start,
            'working_hours' => $request->working_hours,
        ]);

        return redirect('/');
    }
}
