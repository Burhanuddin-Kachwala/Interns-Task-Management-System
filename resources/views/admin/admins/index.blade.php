<x-admin.layout>
    <h1 class="text-xl font-bold mb-4">Admins</h1>
    <a href="{{ route('admin-users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">Add Admin</a>

    <div class="mt-4 overflow-x-auto rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($admins as $admin)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $admin->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $admin->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $admin->role->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $admin->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $admin->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin-users.edit', ['admin_user' => $admin->id]) }}"
                               class="bg-blue-100 text-blue-700 px-3 py-1 rounded-md text-sm hover:bg-blue-200 transition duration-200">
                                Edit
                            </a>

                            <form action="{{ route('admin-users.destroy', ['admin_user' => $admin->id]) }}"
                                  method="POST" onsubmit="return confirm('Delete this admin?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-100 text-red-700 px-3 py-1 rounded-md text-sm hover:bg-red-200 transition duration-200">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin.layout>
