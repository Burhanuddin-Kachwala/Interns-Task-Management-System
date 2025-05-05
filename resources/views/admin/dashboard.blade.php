<x-admin.layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-md">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-indigo-700">
                Welcome, {{ Auth::guard('admin')->user()->name }}
            </h1>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <a href="{{ route('admin.tasks.index') }}" class="bg-indigo-100 border-l-4 border-indigo-500 p-4 rounded hover:shadow">
                <h2 class="text-lg font-bold text-indigo-700">Manage Tasks</h2>
                <p class="text-sm text-gray-600">View, create, assign, or update tasks.</p>
            </a>

            <a href="{{ route('admin.interns.index') }}" class="bg-green-100 border-l-4 border-green-500 p-4 rounded hover:shadow">
                <h2 class="text-lg font-bold text-green-700">Manage Interns</h2>
                <p class="text-sm text-gray-600">List, review, or edit intern profiles.</p>
            </a>
        </div>
    </div>
</x-admin.layout>
