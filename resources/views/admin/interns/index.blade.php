<x-admin.layout>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Interns</h2>
        <a href="{{ route('admin.interns.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Intern</a>
    </div>

    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Role</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interns as $intern)
                <tr class="border-b">
                    <td class="p-3">{{ $intern->name }}</td>
                    <td class="p-3">{{ $intern->email }}</td>
                    <td class="p-3">{{ $intern->role->name ?? 'N/A' }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('admin.interns.edit', $intern) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.interns.destroy', $intern) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this intern?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin.layout>
