<?php
namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Intern;
use Illuminate\Http\Request;
use App\Services\ChatService;
use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SendChatMessageRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

public function send(SendChatMessageRequest $request, $internId)
{
    try {
        // Retrieve the currently authenticated admin user
        $admin = Auth::guard('admin')->user();

        // Send the message using the chat service
        $message = $this->chatService->sendMessage(
            $admin->id,
            'admin',
            $internId,
            'intern',
            $request->message
        );

        // Broadcast the new message to the intern
        broadcast(new NewChatMessage($message, $internId, 'intern'));

        // Return the sent message in the response
        return response()->json(['message' => $message]);

    } catch (ModelNotFoundException $e) {
        // Return an error if the intern is not found
        return response()->json([
            'error' => 'Intern not found',
            'message' => 'The requested intern does not exist'
        ], 404);
    } catch (Exception $e) {
        // Log the exception for debugging
        \Log::error('Error sending chat message: ' . $e->getMessage(), [
            'admin_id' => Auth::guard('admin')->id(),
            'intern_id' => $internId,
            'message' => $request->message
        ]);

        // Return a generic error message
        return response()->json([
            'error' => 'Failed to send message',
            'message' => 'An error occurred while sending the message. Please try again later.'
        ], 500);
    }
}

}