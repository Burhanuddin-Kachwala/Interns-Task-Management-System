<x-admin.layout>
<form method="POST" action="{{ isset($admin) ? route('admins.update', $admin->id) : route('admin-users.store') }}">
    @csrf
    @if(isset($admin)) @method('PUT') @endif

    <label>Name:</label>
    <input name="name" value="{{ old('name', $admin->name ?? '') }}" required>

    <label>Email:</label>
    <input name="email" type="email" value="{{ old('email', $admin->email ?? '') }}" required>

    <label>Role:</label>
    <select name="role_id">
        @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old('role_id', $admin->role_id ?? '') == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <label>Password: @if(isset($admin)) (leave blank to keep current) @endif</label>
    <input name="password" type="password">

    <label>Confirm Password:</label>
    <input name="password_confirmation" type="password">

    <label>
        <input type="checkbox" name="is_active" {{ old('is_active', $admin->is_active ?? true) ? 'checked' : '' }}>
        Is Active
    </label>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-4">
        {{ isset($admin) ? 'Update' : 'Create' }}
    </button>
</form>
</x-admin.layout>