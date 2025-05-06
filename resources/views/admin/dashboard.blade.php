<x-admin.layout>
    <div class="max-w-6xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Left Side - Cards -->
        <div class="md:col-span-2 space-y-6">
            <div class="p-6 bg-white shadow rounded-md">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-semibold text-indigo-700">
                        Welcome, {{ Auth::guard('admin')->user()->name }}
                    </h1>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('admin.tasks.index') }}" class="bg-indigo-100 border-l-4 border-indigo-500 p-4 rounded hover:shadow">
                        <h2 class="text-lg font-bold text-indigo-700">Manage Tasks</h2>
                        <p class="text-sm text-gray-600">View, create, assign, or update tasks.</p>
                    </a>
                    
                    <a href="{{ route('admin.interns.index') }}" class="bg-green-100 border-l-4 border-green-500 p-4 rounded hover:shadow">
                        <h2 class="text-lg font-bold text-green-700">Manage Interns</h2>
                        <p class="text-sm text-gray-600">List, review, or edit intern profiles.</p>
                    </a>
                    @can('manage-roles')
                    <a href="{{ route('admin.roles.index') }}" class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded hover:shadow">
                        <h2 class="text-lg font-bold text-yellow-700">Manage Roles</h2>
                        <p class="text-sm text-gray-600">View, create, assign, or update Roles.</p>
                    </a>
                    @endcan
                    @can('manage-admin')
                    <a href="{{ route('admin-users.index') }}" class="bg-red-100 border-l-4 border-red-500 p-4 rounded hover:shadow">
                        <h2 class="text-lg font-bold text-red-700">Manage Admins</h2>
                        <p class="text-sm text-gray-600">View, create, assign, or update Admin.</p>
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Right Side - Recent Comments -->
        <div class="space-y-4">
            <div class="p-4 bg-white shadow rounded-md">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Recent Comments</h2>

                @forelse ($recentComments as $comment)
                    <div class="mb-3 border-b pb-2">
                        <p class="text-sm text-gray-800">
                            <strong>{{ $comment->intern->name }}</strong> on 
                            <span class="text-indigo-600 font-medium">"{{ $comment->task->title }}"</span>
                        </p>
                        <p class="text-sm text-gray-600 italic truncate">"{{ $comment->comment }}"</p>
                        <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No recent comments.</p>
                @endforelse

                {{-- <a href="{{ route('admin.comments.recent') }}" class="text-indigo-600 text-sm hover:underline">
                    View all →
                </a> --}}
            </div>
        </div>
    </div>
</x-admin.layout>
