<?php

namespace App\Http\Controllers\Tasks;

use App\Models\Task;
use App\Models\Intern;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('interns')->latest()->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $interns = Intern::all();
        return view('admin.tasks.create', compact('interns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
            'interns'     => 'nullable|array',
            'interns.*'   => 'exists:interns,id',
        ]);

        $task = Task::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'admin_id'    => auth('admin')->id(),
            'deadline'    => $request->deadline,
        ]);

        $task->interns()->sync($request->interns ?? []);

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $interns = Intern::all();
        $assignedInterns = $task->interns->pluck('id')->toArray();
        return view('admin.tasks.edit', compact('task', 'interns', 'assignedInterns'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
            'interns'     => 'nullable|array',
            'interns.*'   => 'exists:interns,id',
        ]);

        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'deadline'    => $request->deadline,
        ]);

        $task->interns()->sync($request->interns ?? []);

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted.');
    }
}
