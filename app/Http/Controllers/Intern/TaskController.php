<?php


namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
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
            // ->where('intern_id', Auth::guard('intern')->id())
            //if you want to show the comments only based on the particular user then uncomment it
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

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $task->comments()->latest()->first(),
            'intern_name'=> Auth::guard('intern')->user()->name,
        ]);
    }

    protected function authorizeTask(Task $task)
    {
        if (!Auth::guard('intern')->user()->tasks->contains($task)) {
            abort(403);
        }
    }
}
