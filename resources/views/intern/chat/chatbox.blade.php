<x-layout>
    <meta name="admin-id" content="{{ $admin->id }}">
    <meta name="intern-id" content="{{ auth()->id() }}">
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow rounded p-4">
        <h2 class="text-lg font-bold mb-4">Chat with Admin: {{ $admin->name }}</h2>

        <div class="h-96 overflow-y-scroll border p-4 mb-4 space-y-2 bg-gray-50 rounded chat-container">
            @foreach ($messages as $msg)
            <div class="flex {{ $msg->sender_type === 'intern' ? 'justify-end' : 'justify-start' }}">
                <div
                    class="max-w-xs px-4 py-2 rounded {{ $msg->sender_type === 'intern' ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                    <p>{{ $msg->message }}</p>
                    <p class="text-xs mt-1 text-right opacity-70">{{ $msg->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('intern.chat.send', $admin->id) }}" class="flex space-x-2 message-form">
            @csrf
            <input type="text" name="message" class="w-full border rounded px-3 py-2 message-input"
                placeholder="Type your message...">
            <button type="submit"
                class="bg-green-600 text-white px-4 rounded hover:bg-green-700 send-button">Send</button>
        </form>
    </div>


    <script>
   document.addEventListener('DOMContentLoaded', () => {
    const chatContainer = document.querySelector('.chat-container');
    const messageInput = document.querySelector('.message-input');
    const messageForm = document.querySelector('.message-form');
    const adminId = {{ $admin->id }}; // Blade variables injected here
    const internId = {{ auth()->guard('intern')->id() }}; 

    // Scroll to the bottom on page load
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // Echo private channel listener for admin
    window.Echo.private(`chat.admin.${adminId}`).listen('.new.message', (event) => {
        if (event.message.receiver_type === 'intern' && event.message.receiver_id === internId) {
            const newMessageHtml = `
                <div class="flex justify-start">
                    <div class="max-w-xs px-4 py-2 rounded bg-gray-200">
                        <p>${event.message.message}</p>
                        <p class="text-xs mt-1 text-right opacity-70">${formatTimeAgo(event.message.created_at)}</p>
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', newMessageHtml);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });

    // Echo private channel listener for intern
    window.Echo.private(`chat.intern.${internId}`).listen('.new.message', (event) => {
        if (event.message.sender_type === 'intern' && event.message.sender_id === internId && event.message.receiver_type === 'admin' && event.message.receiver_id === adminId) {
            const newMessageHtml = `
                <div class="flex justify-end">
                    <div class="max-w-xs px-4 py-2 rounded bg-green-500 text-white">
                        <p>${event.message.message}</p>
                        <p class="text-xs mt-1 text-right opacity-70">${formatTimeAgo(event.message.created_at)}</p>
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', newMessageHtml);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });

    // Form submission handling with Axios
    messageForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent default form submission (page refresh)

        const messageText = messageInput.value.trim();

        if (messageText) {
            axios.post(messageForm.action, { message: messageText })
                .then(response => {
                    if (response.data && response.data.message) {
                        const newMessageHtml = `
                            <div class="flex justify-end">
                                <div class="max-w-xs px-4 py-2 rounded bg-green-500 text-white">
                                    <p>${response.data.message.message}</p>
                                    <p class="text-xs mt-1 text-right opacity-70">${formatTimeAgo(response.data.message.created_at)}</p>
                                </div>
                            </div>
                        `;
                        chatContainer.insertAdjacentHTML('beforeend', newMessageHtml);
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                        messageInput.value = ''; // Clear input field after sending
                    } else {
                        console.error('Error sending message:', response.data);
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
        }
    });

    function formatTimeAgo(dateTimeString) {
        const now = new Date();
        const past = new Date(dateTimeString);
        const diffInSeconds = Math.floor((now - past) / 1000);

        if (diffInSeconds < 60) {
            return `${diffInSeconds} seconds ago`;
        } else if (diffInSeconds < 3600) {
            const diffInMinutes = Math.floor(diffInSeconds / 60);
            return `${diffInMinutes} minutes ago`;
        } else if (diffInSeconds < 86400) {
            const diffInHours = Math.floor(diffInSeconds / 3600);
            return `${diffInHours} hours ago`;
        } else {
            return past.toLocaleDateString() + ' ' + past.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }
});

    </script>
</x-layout>