<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve tasks from the JSON file
        $tasks = json_decode(file_get_contents(storage_path('app/data/tasks.json')), true);

        return view('tasks.index', compact('tasks'));
    }
    public function create()
    {
        return view('tasks.create');
    }
    public function store(Request $request)
    {
        // Validate the task title
        $validatedData = $request->validate([
            'title' => 'required|max:100',
        ]);

        // Create a new task instance
        $task = new Task();
        $task->title = $request->input('title');
        $task->date_added = date('Y-m-d');
        $task->save();

        // Retrieve tasks from the JSON file
        $tasks = json_decode(file_get_contents(storage_path('app/data/tasks.json')), true);

        // Add the new task to the array
        $tasks[] = $task->toArray();

        // Store the tasks in the JSON file
        file_put_contents(storage_path('app/data/tasks.json'), json_encode($tasks));

        return redirect()->route('tasks.index')->with('success', 'Task added successfully.');
    }
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100'
        ]);

        $task->title = $request->input('title');
        $updated = $task->save();

        if ($updated) {
            return response()->json(['success' => 'Task title updated successfully.']);
        } else {
            return response()->json(['error' => 'Failed to update task title.'], 500);
        }
    }
    public function destroy($id)
    {
        // Retrieve tasks from the JSON file
        $tasks = json_decode(file_get_contents(storage_path('app/data/tasks.json')), true);

        // Find the task by ID
        $taskKey = array_search($id, array_column($tasks, 'id'));

        if ($taskKey !== false) {
            // Remove the task from the array
            unset($tasks[$taskKey]);

            // Store the updated tasks in the JSON file
            file_put_contents(storage_path('app/data/tasks.json'), json_encode(array_values($tasks)));

            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
        }

        return redirect()->route('tasks.index')->with('error', 'Task not found.');
    }
}
