<x-admin.layout>
    <h1 class="text-2xl font-bold mb-4">Edit Permission</h1>

    <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
        @csrf @method('PUT')
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ $permission->name }}" class="border rounded p-2 w-full" required>
        </div>

        {{-- <div class="mt-4">
            <label>Slug:</label>
            <input type="text" name="slug" value="{{ $permission->slug }}" class="border rounded p-2 w-full" required>
        </div> --}}

        <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-admin.layout>
