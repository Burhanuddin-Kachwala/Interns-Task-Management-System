<x-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-4">Select an Admin to Chat</h2>
        <ul class="space-y-2">
            @foreach ($admins as $admin)
                <li>
                    <a href="{{ route('intern.chat.show', $admin->id) }}"
                       class="block p-3 bg-gray-100 hover:bg-green-100 rounded shadow">
                        {{ $admin->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</x-layout>
