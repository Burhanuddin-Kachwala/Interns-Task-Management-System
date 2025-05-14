<?php
namespace App\Http\Controllers\Admin;

use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        try {
            $interns = Intern::all();
            return view('admin.chat.index', compact('interns'));
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to load interns list',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($internId)
    {
        try {
            $admin = Auth::guard('admin')->user();
            $intern = Intern::findOrFail($internId);

            $messages = $this->chatService->getConversation(
                $admin->id,
                'admin',
                $internId,
                'intern'
            );

            return view('admin.chat.chatbox', compact('admin', 'intern', 'messages'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Intern not found',
                'message' => 'The requested intern does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to load chat',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function send(Request $request, $internId)
    {
        try {
            $request->validate(['message' => 'required|string']);

            $admin = Auth::guard('admin')->user();

            $message = $this->chatService->sendMessage(
                $admin->id,
                'admin',
                $internId,
                'intern',
                $request->message
            );
            
            broadcast(new NewChatMessage($message, $internId, 'intern'));

            return response()->json(['message' => $message]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Intern not found',
                'message' => 'The requested intern does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to send message',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
