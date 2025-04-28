import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
// export default defineConfig({
//     plugins: [
//         laravel(['resources/js/app.jsx']),
//         react(),
//     ],
// });
// export default defineConfig({
//     plugins: [react()],
//     resolve: {
//       alias: {
//         '@': '/resources',
//       },
//     },
//     build: {
//       rollupOptions: {
//         input: [
//           'resources/js/app.jsx', // ou ton fichier d'entrée
//           'resources/js/Index.jsx', // ce fichier doit exister
//         ],
//       },
//     },
//   });
  




export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/Pages/app.jsx', // Assure-toi que ce chemin existe

              ],
            refresh: true,
        }),
        react(),
    ],
});

