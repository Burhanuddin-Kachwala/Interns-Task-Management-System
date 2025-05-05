<x-admin.layout>
    <h2>Chat with {{ $intern->name }}</h2>

    <div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
        @foreach($messages as $msg)
            <div class="flex {{ $msg->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                <div class="{{ $msg->sender_type === 'admin' ? 'bg-blue-200' : 'bg-gray-200' }} p-2 rounded max-w-xs">
                    <p class="text-sm">{{ $msg->message }}</p>
                    <small class="block text-gray-600 text-xs">{{ $msg->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('admin.chat.send',$intern->id) }}" method="POST" class="flex gap-2">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $intern->id }}">
        <input type="hidden" name="receiver_type" valu  e="intern">
        <input type="text" name="message" class="border p-2 flex-1 rounded" placeholder="Type message...">
        <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Send</button>
    </form>
</x-admin.layout>
