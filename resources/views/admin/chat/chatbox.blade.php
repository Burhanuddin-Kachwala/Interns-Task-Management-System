<x-admin.layout>
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow rounded p-4">
        <h2 class="text-lg font-bold mb-4">Chat with Intern: {{ $intern->name }}</h2>
        <div class="h-96 overflow-y-scroll border p-4 mb-4 space-y-2 bg-gray-50 rounded chat-container">
            @foreach ($messages as $msg)
                <div class="flex {{ $msg->sender_type === 'admin' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs px-4 py-2 rounded {{ $msg->sender_type === 'admin' ? 'bg-indigo-500 text-white' : 'bg-gray-200' }}">
                        <p>{{ $msg->message }}</p>
                        <p class="text-xs mt-1 text-right opacity-70">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <form id="admin_chat_box" method="POST" action="{{ route('admin.chat.send', $intern->id) }}" class="flex space-x-2 message-form">
            @csrf
            <input type="text" name="message" class="w-full border rounded px-3 py-2 message-input" placeholder="Type your message...">
            <button type="submit" class="bg-indigo-600 text-white px-4 rounded hover:bg-indigo-700 send-button">Send</button>
        </form>
    </div>

    

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chatContainer = document.querySelector('.chat-container');
            const messageInput = document.querySelector('.message-input');
            const messageForm = document.querySelector('.message-form');
            const adminId = {{ auth()->guard('admin')->id() }};
            const internId = {{ $intern->id }};
        
            // Scroll to bottom on load
            chatContainer.scrollTop = chatContainer.scrollHeight;          
            // Echo listener for intern > admin messages
            window.Echo.private(`chat.admin.${adminId}`).listen('.NewChatMessage', (event) => {   
                console.log('Admin message received'); 
                // Create notification
        const showNotification = (message) => {
            const notification = document.createElement('div');
            notification.classList.add('fixed', 'right-4', 'bottom-10', 'bg-green-100', 'text-gray-600', 'px-3', 'py-1', 'rounded', 'shadow-sm', 'text-sm', 'opacity-90');
            notification.textContent = 'New message received';
            document.body.appendChild(notification);
            
            // Fade out effect
            setTimeout(() => {
            notification.style.transition = 'opacity 0.5s';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
            }, 2000);
        };

        // Call notification when new message arrives
        showNotification();
                if (event.message.sender_type === 'intern' && event.message.sender_id === internId) {
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
        
            // // Echo listener for admin > intern (self messages)
            // window.Echo.private(`chat.intern.${internId}`).listen('.NewChatMessage', (event) => {
            //     console.log('Intern message received'); // Debugging line

            //     if (event.message.sender_type === 'admin' && event.message.sender_id === adminId) {
            //         const newMessageHtml = `
            //             <div class="flex justify-end">
            //                 <div class="max-w-xs px-4 py-2 rounded bg-blue-500 text-white">
            //                     <p>${event.message.message}</p>
            //                     <p class="text-xs mt-1 text-right opacity-70">${formatTimeAgo(event.message.created_at)}</p>
            //                 </div>
            //             </div>
            //         `;
            //         chatContainer.insertAdjacentHTML('beforeend', newMessageHtml);
            //         chatContainer.scrollTop = chatContainer.scrollHeight;
            //     }
            // });
        
            // Axios message send
            messageForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const messageText = messageInput.value.trim();
        
                if (messageText) {
                    axios.post(messageForm.action, { message: messageText })
                        .then(response => {
                            if (response.data && response.data.message) {
                                const newMessageHtml = `
                                    <div class="flex justify-end">
                                        <div class="max-w-xs px-4 py-2 rounded bg-indigo-500 text-white">
                                            <p>${response.data.message.message}</p>
                                            <p class="text-xs mt-1 text-right opacity-70">${formatTimeAgo(response.data.message.created_at)}</p>
                                        </div>
                                    </div>
                                `;
                                chatContainer.insertAdjacentHTML('beforeend', newMessageHtml);
                                chatContainer.scrollTop = chatContainer.scrollHeight;
                                messageInput.value = '';
                            }
                        })
                        .catch(error => {
                            console.error('Message sending failed:', error);
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
        
</x-admin.layout>