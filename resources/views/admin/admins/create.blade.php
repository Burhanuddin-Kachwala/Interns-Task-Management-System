<x-admin.layout>
    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-lg p-8">
        <form id="admin_create_admin" method="POST" action="{{ isset($admin) ? route('admins.update', $admin->id) : route('admin-users.store') }}">
            @csrf
            @if(isset($admin)) @method('PUT') @endif

            <h2 class="text-2xl font-semibold mb-6">{{ isset($admin) ? 'Edit Admin' : 'Create Admin' }}</h2>

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block font-medium mb-1">Name:</label>
                <input id="name" name="name" type="text" class="w-full border rounded px-3 py-2" value="{{ old('name', $admin->name ?? '') }}" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-medium mb-1">Email:</label>
                <input id="email" name="email" type="email" class="w-full border rounded px-3 py-2" value="{{ old('email', $admin->email ?? '') }}" required>
            </div>

            <!-- Role -->
            <div class="mb-4">
                <label for="role_id" class="block font-medium mb-1">Role:</label>
                <select id="role_id" name="role_id" class="w-full border rounded px-3 py-2">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $admin->role_id ?? '') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block font-medium mb-1">Password: @if(isset($admin)) <span class="text-sm text-gray-500">(leave blank to keep current)</span> @endif</label>
                <input id="password" name="password" type="password" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block font-medium mb-1">Confirm Password:</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Is Active -->
            <div class="mb-4 flex items-center">
                <input id="is_active" type="checkbox" name="is_active" class="mr-2" {{ old('is_active', $admin->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active" class="font-medium">Is Active</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">
                {{ isset($admin) ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
</x-admin.layout>
