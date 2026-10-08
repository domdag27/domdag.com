import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
	plugins: [tailwindcss()],
	base: '', // relative asset paths; PHP builds the real URLs
	build: {
		outDir: 'dist',
		manifest: true,
		emptyOutDir: true,
		rollupOptions: {
			input: { main: 'src/js/main.js' },
		},
	},
});
