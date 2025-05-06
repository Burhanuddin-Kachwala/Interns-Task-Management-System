<x-admin.layout>
    <h1 class="text-xl font-bold mb-4">Admins</h1>
    <a href="{{ route('admin-users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Admin</a>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->role->name ?? 'N/A' }}</td>
                <td>{{ $admin->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('admin-users.edit', $admin->id) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('admin-users.destroy', $admin->id) }}" method="POST" class="inline-block">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this admin?')" class="text-red-600 ml-2">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-admin.layout>
