<x-layout>
    <h1 class="text-2xl font-bold mb-4">Your Tasks</h1>

    @foreach ($tasks as $task)
        <div class="bg-white p-4 rounded shadow mb-3">
            <h2 class="text-lg font-semibold">{{ $task->title }}</h2>
            <p class="text-gray-700">{{ Str::limit($task->description, 100) }}</p>
            <p class="text-sm text-gray-500">Assigned by: {{ $task->admin->name }}</p>
            <a href="{{ route('intern.tasks.show', $task) }}" class="text-indigo-600 underline text-sm">View Details</a>
        </div>
    @endforeach
</x-layout>
