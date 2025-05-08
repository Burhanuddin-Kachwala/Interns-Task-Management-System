<x-admin.layout>
    <h2 class="text-xl font-semibold mb-4">Add New Intern</h2>

    <form id="admin_create_intern" action="{{ route('admin.interns.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm mb-1">Name</label>
            <input type="text" id="name" name="name" required class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm mb-1">Email</label>
            <input type="email" id="email" name="email" required class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm mb-1">Password</label>
            <input type="password" id="password" name="password" required class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm mb-1">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full border rounded p-2">
        </div>

        {{-- <label class="block text-sm">Role</label>
        <select name="role_id" class="w-full border rounded p-2">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select> --}}

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Create</button>
    </form>
</x-admin.layout>
