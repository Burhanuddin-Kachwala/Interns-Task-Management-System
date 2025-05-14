<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Requests\Intern\StoreTaskCommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Http\Request;
use Exception;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Auth::guard('intern')->user()->tasks()->with('admin')->get();
            return view('intern.tasks.index', compact('tasks'));
        } catch (Exception $e) {
            return back()->with('error', 'Unable to fetch tasks: ' . $e->getMessage());
        }
    }

    public function show(Task $task)
    {
        try {
            $this->authorizeTask($task);

            $comments = $task->comments()
                ->with('intern')
                ->latest()
                ->get();
            return view('intern.tasks.show', compact('task', 'comments'));
        } catch (Exception $e) {
            return back()->with('error', 'Unable to display task: ' . $e->getMessage());
        }
    }

 public function storeComment(StoreTaskCommentRequest $request, Task $task)
{
    try {
        $this->authorizeTask($task);

        $comment = $task->comments()->create([
            'intern_id' => Auth::guard('intern')->id(),
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $comment,
            'intern_name' => Auth::guard('intern')->user()->name,
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to add comment: ' . $e->getMessage()
        ], 500);
    }
}


    protected function authorizeTask(Task $task)
    {
        try {
            if (!Auth::guard('intern')->user()->tasks->contains($task)) {
                abort(403, 'Unauthorized access to task');
            }
        } catch (Exception $e) {
            abort(500, 'Error checking task authorization: ' . $e->getMessage());
        }
    }
}
