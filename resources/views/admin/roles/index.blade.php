<x-admin.layout>
    <h1 class="text-2xl font-bold mb-4">Roles</h1>
    <a href="{{ route('admin.permissions.index') }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Manage Permissions</a>

    <a href="{{ route('admin.roles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add Role</a>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->slug }}</td>
                    <td>
                        @foreach($role->permissions as $perm)
                            <span class="bg-gray-200 px-2 rounded">{{ $perm->name }}</span>
                        @endforeach
                    </td>
                    <td class="space-x-2">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline-block">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete this role?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin.layout>
