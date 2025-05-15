<x-admin.layout>
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ isset($admin) ? 'Edit Admin' : 'Create Admin' }}
        </h1>

        <form id="admin_edit_admin" method="POST" action="{{ route('admin-users.update', $admin->id ?? '') }}">
            @csrf
            @if(isset($admin)) @method('PUT') @endif

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-gray-700 font-medium">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $admin->name ?? '') }}"
                        required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 font-medium">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $admin->email ?? '') }}"
                        required class="mt-1 block w-full px-4 py-2 border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        readonly>
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role_id" class="block text-gray-700 font-medium">Role</label>
                    <select id="role_id" name="role_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $admin->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 font-medium">Password</label>
                    <input id="password" name="password" type="password" 
                        placeholder="Leave blank to keep current password" 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            {{-- <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('password_confirmation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

                <!-- Is Active -->
                <div class="flex items-center space-x-2">
                    <input id="is_active" type="checkbox" name="is_active" 
                        {{ old('is_active', $admin->is_active ?? true) ? 'checked' : '' }} 
                        class="h-5 w-5 text-blue-600 border-gray-300 rounded">
                    <label for="is_active" class="text-gray-700">Is Active</label>
                </div>

                <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg mt-6 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    {{ isset($admin) ? 'Update Admin' : 'Create Admin' }}
                </button>
            </div>
        </form>
    </div>
</x-admin.layout>
