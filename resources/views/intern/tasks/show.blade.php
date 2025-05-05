<x-layout>
    <h1 class="text-2xl font-bold mb-4">{{ $task->title }}</h1>
    <p class="mb-2 text-gray-700">{!! $task->description!!}</p>
    <p class="text-sm text-gray-600 mb-4">Deadline: {{ $task->deadline }}</p>

    <hr class="my-4">

    <h2 class="text-xl font-semibold mb-2">Comments</h2>

    @foreach ($comments as $comment)
        <div class="bg-gray-100 p-3 rounded mb-2">
            <p class="text-sm">{{ $comment->comment }}</p>
            <p class="text-xs text-gray-500 mt-1">By {{ $comment->intern->name }} | {{ $comment->created_at->diffForHumans() }}</p>
        </div>
    @endforeach

    <form action="{{ route('intern.tasks.comment', $task) }}" method="POST" class="mt-4">
        @csrf
        <textarea name="comment" rows="3" required class="w-full p-2 border rounded" placeholder="Add a comment..."></textarea>
        <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Comment</button>
    </form>
</x-layout>
