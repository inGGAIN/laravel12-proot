import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                beach: {
                    blue: '#0046ff',   // Biru Utama
                    cyan: '#73c8d2',   // Cyan Air
                    sand: '#f9f9f9',   // Krem Pasir
                    orange: '#ff9013', // Oranye Matahari
                },
            },
        },
    },

    plugins: [forms],
};
