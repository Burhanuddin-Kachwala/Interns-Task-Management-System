<h1>Welcome, {{ Auth::user()->name }}</h1>
<p>Here are your assigned tasks:</p>

<form action="{{ route('intern.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>