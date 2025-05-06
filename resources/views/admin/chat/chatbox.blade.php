<x-admin.layout>
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow rounded p-4">
        <h2 class="text-lg font-bold mb-4">Chat with Intern: {{ $intern->name }}</h2>
        <div class="h-96 overflow-y-scroll border p-4 mb-4 space-y-2 bg-gray-50 rounded">
            @foreach ($messages as $msg)
                <div class="flex {{ $msg->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs px-4 py-2 rounded {{ $msg->sender_type === 'admin' ? 'bg-indigo-500 text-white' : 'bg-gray-200' }}">
                        <p>{{ $msg->message }}</p>
                        <p class="text-xs mt-1 text-right opacity-70">{{ $msg->created_at->diffForHumans()}}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('admin.chat.send', $intern->id) }}" class="flex space-x-2">
            @csrf
            <input type="text" name="message" class="w-full border rounded px-3 py-2" placeholder="Type your message...">
            <button type="submit" class="bg-indigo-600 text-white px-4 rounded hover:bg-indigo-700">Send</button>
        </form>
    </div>
</x-admin.layout>
