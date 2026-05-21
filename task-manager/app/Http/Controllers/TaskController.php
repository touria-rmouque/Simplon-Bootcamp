<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task; 
use App\Models\Category; 
use Illuminate\Http\Request;

class TaskController extends Controller
{
   public function index(Request $request)
{
    $query = auth()->user()->tasks()->with('category');

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    $tasks = $query->latest()->paginate(8);
    
    $categories = Category::all();

    return view('tasks.index', compact('tasks', 'categories'));
}

public function edit(Task $task)
{
    if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $categories = Category::all();
    return view('tasks.edit', compact('task', 'categories'));
}

public function update(Request $request, Task $task)
{
    if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $fields = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:todo,in_progress,done', 
        'due_date' => 'nullable|date',
    ]);

    $task->update($fields);

    return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour !');
}

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'due_date' => 'nullable|date',
        ]);

        $fields['user_id'] = auth()->id();
        $fields['status'] = 'todo'; 

        Task::create($fields);

        return redirect()->route('tasks.index')->with('success', 'Tâche créée !');
    }

    public function updateStatus(Request $request, Task $task)
{
    $validated = $request->validate([
        'status' => 'required|in:todo,in_progress,done',
    ]);

    $task->update($validated);

    return back()->with('success', 'Statut mis à jour avec succès !');
}

public function show(Task $task)
{
    $task->load('category'); 
    
    return view('tasks.show', compact('task'));
}

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }

        $task->delete();
        return back()->with('success', 'Tâche supprimée !');
    }
}