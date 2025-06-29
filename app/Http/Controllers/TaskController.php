<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = Auth::user()->tasks();

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    $tasks = $query->latest()->paginate(5); // Change 5 to 10 for more per page

    return view('tasks.index', compact('tasks'));
}



    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Task $task)
{
    // ensure user can edit only their own tasks
    if (Auth::id() !== $task->user_id) {
        abort(403);
    }

    return view('tasks.edit', compact('task'));
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Task $task)
{
    if (Auth::id() !== $task->user_id) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,in-progress,completed',
    ]);

    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Task $task)
{
    // Secure: check user ownership
    if (Auth::id() !== $task->user_id) {
        abort(403);
    }

    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
}

}
