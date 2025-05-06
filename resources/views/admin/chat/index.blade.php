<x-admin.layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-indigo-700">Admin Chat</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        @foreach ($interns as $intern)
            <a href="{{ route('admin.chat.show', $intern->id) }}" class="bg-blue-100 border-l-4 border-blue-500 p-4 rounded hover:shadow">
                <h2 class="text-lg font-bold text-blue-700">{{ $intern->name }}</h2>
                <p class="text-sm text-gray-600">Click to start chatting with {{ $intern->name }}.</p>
            </a>
        @endforeach
    </div>
</x-admin.layout>
