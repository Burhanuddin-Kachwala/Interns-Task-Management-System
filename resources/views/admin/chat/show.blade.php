<x-admin.layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-md">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-indigo-700">
                Chat with {{ $intern->name }}
            </h1>
        </div>

        <div class="bg-gray-50 p-4 rounded shadow mb-6">
            <div class="space-y-4">
                @foreach ($messages as $message)
                    <div class="flex {{ $message->sender_id == auth()->guard('admin')->id() ? 'justify-end' : 'justify-start' }} p-2">
                        <div class="bg-indigo-100 p-3 rounded-lg max-w-xs">
                            <p class="text-sm">{{ $message->message }}</p>
                            <span class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <form action="{{ route('admin.chat.send', $intern->id) }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="message" class="border p-2 flex-1 rounded" placeholder="Type message..." required>
            <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded">Send</button>
        </form>
    </div>
</x-admin.layout>
