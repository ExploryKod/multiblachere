import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        outDir: 'dist/build',
        manifest: true,
        rollupOptions: {
            input: {
                cp: 'resources/js/cp.js'
            },
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: 'css/[name].[ext]'
            }
        }
    }
});
