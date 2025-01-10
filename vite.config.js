import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        require('@vitejs/plugin-vue')(),
    ],
    build: {
        outDir: 'public/build',
    },
    optimizeDeps: {
        include: ['chart.js'],
    },
});
