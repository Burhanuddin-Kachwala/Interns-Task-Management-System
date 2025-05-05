<x-layout>
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-indigo-600">
            Welcome, {{ Auth::guard('intern')->user()->name }}
        </h1>
{{-- 
        <form action="{{ route('intern.logout') }}" method="POST" class="mb-6">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Logout
            </button>
        </form> --}}

        <p class="mb-4 text-gray-700">Here are your assigned tasks:</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($tasks->count() > 0)
                @foreach($tasks as $task)
                    <a href="{{ route('intern.tasks.show', $task->id) }}" class="block">
                        <div class="p-4 border border-gray-200 rounded bg-gray-50 hover:bg-gray-100 transition duration-150 ease-in-out">
                            <h2 class="text-lg font-semibold text-purple-700">{{ $task->title }}</h2>
                            <p class="text-sm text-gray-600">Deadline: {{ $task->deadline }}</p>
                            <p class="mt-2 text-gray-800 truncate">{!! $task->description !!}</p>
                            <div class="mt-3 text-indigo-600 text-sm">
                                Click to view details →
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="col-span-2 p-4 text-center text-gray-500 border border-gray-200 rounded">
                    No tasks assigned yet.
                </div>
            @endif
        </div>
    </div>
</x-layout>
