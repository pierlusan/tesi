import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/main.css',
                'resources/css/room.css',
                'resources/css/webrtc.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/calendar.css',
                'resources/js/multiselect.js',
                'resources/js/edit-group.js',
                'resources/js/room.js',
                'resources/js/roomrtc.js',
                'resources/js/webrtc.js',
                'resources/js/agora-rtm-sdk-1.5.1.js',
                'resources/js/AgoraRTC_N-4.19.1.js',
                'resources/js/notifiche.js'
            ],
            refresh: true,
        }),
    ],
});
