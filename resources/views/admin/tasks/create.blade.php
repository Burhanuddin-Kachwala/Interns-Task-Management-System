<x-admin.layout>
    <h2 class="text-2xl font-bold text-indigo-600 mb-6">Create Task</h2>

    <form action="{{ route('admin.tasks.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-medium">Title</label>
            <input type="text" name="title" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded summernote"></textarea>
        </div>

        <div>
            <label class="block font-medium">Deadline</label>
            <input type="date" name="deadline" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div>
            <label class="block font-medium">Assign Interns</label>
            <select name="interns[]" multiple class="w-full border rounded px-2 py-1">
                @foreach ($interns as $intern)
                    <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Save Task</button>
    </form>
</x-admin.layout>
