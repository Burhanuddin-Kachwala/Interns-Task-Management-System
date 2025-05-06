<x-admin.layout>
    <h1 class="text-2xl font-bold mb-4">Create Permission</h1>

    <form method="POST" action="{{ route('admin.permissions.store') }}">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name" class="border rounded p-2 w-full" required>
        </div>

        {{-- <div class="mt-4">
            <label>Slug:</label>
            <input type="text" name="slug" class="border rounded p-2 w-full" required>
        </div> --}}

        <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Save</button>
    </form>
</x-admin.layout>
