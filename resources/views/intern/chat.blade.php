<x-layout>
    <h2>Chat with Admin</h2>

    <div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
        @foreach($messages as $msg)
            <div class="flex {{ $msg->sender_type === 'intern' ? 'justify-end' : 'justify-start' }}">
                <div class="{{ $msg->sender_type === 'intern' ? 'bg-green-200' : 'bg-gray-200' }} p-2 rounded max-w-xs">
                    <p class="text-sm">{{ $msg->message }}</p>
                    <small class="block text-gray-600 text-xs">{{ $msg->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('intern.chat.send', $admin->id) }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="message" class="border p-2 flex-1 rounded" placeholder="Type message..." required>
        <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded">Send</button>
    </form>
    
    
</x-layout>
