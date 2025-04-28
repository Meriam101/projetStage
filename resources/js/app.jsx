import './bootstrap'
import ReactDOM from 'react-dom/client';
import Index from './Pages/Index';
import React from 'react';
// createInertiaApp({
//   resolve: name => {
//     const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true })
//     return pages[`./Pages/${name}.jsx`]
//   },
//   setup({ el, App, props }) {
//     createRoot(el).render(<App {...props} />)
//   },
// })
// Monte le composant uniquement si l'élément est présent dans le DOM
const reactDiv = document.getElementById('react-index');
if (reactDiv) {
  const root = ReactDOM.createRoot(reactDiv);
  root.render(
    <React.StrictMode>
      <Index />
  </React.StrictMode>
  );
}
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Ajout du CSRF token pour Laravel
// const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
// if (token) {
//   axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
// }

   
