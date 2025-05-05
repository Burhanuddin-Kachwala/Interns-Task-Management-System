<x-admin.layout>
    <h2 class="text-xl font-semibold mb-4">Edit Intern</h2>

    <form action="{{ route('admin.interns.update', $intern) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm">Name</label>
            <input type="text" id="name" name="name" value="{{ $intern->name }}" required 
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm">Email</label>
            <input type="email" id="email" name="email" value="{{ $intern->email }}" required 
                class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm">Role</label>
            <select name="role_id" class="w-full border rounded p-2">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $intern->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-admin.layout>
