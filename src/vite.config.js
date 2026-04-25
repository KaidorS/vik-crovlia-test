import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/admin/theme.css'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',              // слушаем внутри контейнера
        port: 5173,
        strictPort: true,
        cors: true,
        origin: 'http://localhost:5173',  // <-- КЛЮЧ: подменяет URL в тегах <script>/<link>
        hmr: {
            host: 'localhost',            // для Hot Module Replacement
            port: 5173,
        },
    },
});
