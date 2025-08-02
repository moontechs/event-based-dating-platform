import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import tailwindcss from '@tailwindcss/vite';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php',
        './node_modules/preline/dist/*.js',
        tailwindcss(),
    ],

    plugins: [
        forms,
        typography,
        require('preline/plugin'),
    ],
}
