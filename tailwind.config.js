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
                primary: '#af1e1eff',
                'primary-light': '#EC9A9A',
                secondary: '#fbb024ff',
                accent: '#10aeb9ff',
                BlackBlue: '#4343a5ff'    
            },
        },
    },

    plugins: [forms],
};
