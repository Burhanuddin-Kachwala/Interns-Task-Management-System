<x-admin.layout>
    <h1 class="text-xl font-bold mb-4">Admins</h1>
    <a href="{{ route('admin-users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Admin</a>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="text-left bg-gray-100">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Role</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2">{{ $admin->name }}</td>
                <td class="px-4 py-2">{{ $admin->email }}</td>
                <td class="px-4 py-2">{{ $admin->role->name ?? 'N/A' }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded text-white text-sm {{ $admin->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ $admin->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-4 py-2 flex items-center gap-3">
                    {{-- Edit Button --}}
                    <a href="{{ route('admin-users.edit', ['admin_user' => $admin->id]) }}"
                       class="text-blue-600 hover:text-blue-800" title="Edit">
                        ✏️
                    </a>

                    {{-- Delete Form --}}
                    <form action="{{ route('admin-users.destroy', ['admin_user' => $admin->id]) }}"
                          method="POST" onsubmit="return confirm('Delete this admin?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:text-red-800" title="Delete">
                            🗑️
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-admin.layout>
