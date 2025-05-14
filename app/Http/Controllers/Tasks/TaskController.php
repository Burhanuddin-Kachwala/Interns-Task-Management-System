<?php

namespace App\Http\Controllers\Tasks;

use App\Models\Task;
use App\Models\Intern;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::with('interns')->latest()->get();
            return view('admin.tasks.index', compact('tasks'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading tasks: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $interns = Intern::all();
            return view('admin.tasks.create', compact('interns'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
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

        try {
            DB::beginTransaction();

            $task = Task::create([
                'title'       => $request->title,
                'slug'        => Str::slug($request->title) . '-' . Str::random(5),
                'description' => $request->description,
                'admin_id'    => auth('admin')->id(),
                'deadline'    => $request->deadline,
            ]);

            $task->interns()->sync($request->interns ?? []);

            DB::commit();
            return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create task: ' . $e->getMessage());
        }
    }

    public function edit(Task $task)
    {
        try {
            $interns = Intern::all();
            $assignedInterns = $task->interns->pluck('id')->toArray();
            return view('admin.tasks.edit', compact('task', 'interns', 'assignedInterns'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
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

        try {
            DB::beginTransaction();

            $task->update([
                'title'       => $request->title,
                'description' => $request->description,
                'deadline'    => $request->deadline,
            ]);

            $task->interns()->sync($request->interns ?? []);

            DB::commit();
            return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update task: ' . $e->getMessage());
        }
    }

    public function destroy(Task $task)
    {
        try {
            DB::beginTransaction();
            $task->delete();
            DB::commit();
            return back()->with('success', 'Task deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete task: ' . $e->getMessage());
        }
    }
}
