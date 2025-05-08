import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? '127.0.0.1',
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: false,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    cluster: 'mt1',
    authEndpoint: '/broadcasting/auth',
    withCredentials: true,
    auth: {
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        }
    }
});