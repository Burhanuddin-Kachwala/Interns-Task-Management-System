<x-admin.layout>
<h1>Welcome, {{ Auth::guard('admin')->user()->name }}</h1>
<p>Here are your assigned tasks:</p>

<form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
</x-admin.layout>