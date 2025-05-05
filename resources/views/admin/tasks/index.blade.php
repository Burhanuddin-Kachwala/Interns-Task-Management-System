<x-admin.layout>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-indigo-600">All Tasks</h2>
        <a href="{{ route('admin.tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-indigo-600">+ Create Task</a>
    </div>

    <table class="w-full bg-white rounded shadow">
        <thead class="bg-gray-100">
            <tr class="text-left text-sm">
                <th class="p-3">Title</th>
                <th class="p-3">Deadline</th>
                <th class="p-3">Assigned Interns</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="border-t">
                    <td class="p-3 font-medium">{{ $task->title }}</td>
                    <td class="p-3">{{ $task->deadline }}</td>
                    <td class="p-3">{{ $task->interns->count() }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this task?')" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin.layout>
