<x-admin.layout>
    <h1 class="text-2xl font-bold mb-4">Edit Role</h1>

    <form id="admin_edit_role" method="POST" action="{{ route('admin.roles.update', $role) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="font-semibold">Role Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" class="border rounded p-2 w-full">
        </div>

        <div class="mb-4">
            <label for="is_superadmin" class="font-semibold">Is Superadmin?</label>
            <input type="checkbox" name="is_superadmin" id="is_superadmin" value="1" {{ old('is_superadmin') ? 'checked' : '' }}>
        </div>

        <div id="permissions-container">
            <label class="block font-semibold mb-2">Assign Permissions:</label>
            @foreach ($permissions as $permission)
                <div>
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }} class="permission-checkbox">
                    {{ $permission->name }}
                </div>
            @endforeach
        </div>

        <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</x-admin.layout>

<script>
    function togglePermissions(disable) {
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.disabled = disable;
        });
    }

    const isSuperAdminCheckbox = document.getElementById('is_superadmin');
    isSuperAdminCheckbox.addEventListener('change', function () {
        togglePermissions(this.checked);
    });

    // Initial load (in case of edit)
    if (isSuperAdminCheckbox.checked) {
        togglePermissions(true);
    }
</script>
