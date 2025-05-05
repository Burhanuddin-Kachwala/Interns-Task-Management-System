<?php

// app/Http/Controllers/Intern/TaskController.php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::guard('intern')->user()->tasks()->with('admin')->get();
        return view('intern.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);

        $comments = $task->comments()
            ->with('intern')
            ->where('intern_id', Auth::guard('intern')->id())
            ->latest()
            ->get();
        return view('intern.tasks.show', compact('task', 'comments'));
    }

    public function storeComment(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $task->comments()->create([
            'intern_id' => Auth::guard('intern')->id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    protected function authorizeTask(Task $task)
    {
        if (!Auth::guard('intern')->user()->tasks->contains($task)) {
            abort(403);
        }
    }
}
