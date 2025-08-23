import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Подключаем Pusher к window (нужно для Echo)
window.Pusher = Pusher;

// Инициализация Laravel Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'b70f237e6f2b197ac595',
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    authEndpoint: '/broadcasting/auth', // важно!
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    },
});