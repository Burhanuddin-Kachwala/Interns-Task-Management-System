<x-admin.layout>
    <h1 class="text-2xl font-bold mb-4">Permissions</h1>

    <a href="{{ route('admin.permissions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add Permission</a>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->slug }}</td>
                    <td class="space-x-2">
                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete this permission?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin.layout>
