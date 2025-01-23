import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import lineClamp from '@tailwindcss/line-clamp';

const colors = require('tailwindcss/colors');

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
                primary: colors.emerald,
                secondary: colors.slate,
            },
        },
    },

    //plugins: [forms, lineClamp],
    plugins: [forms],
};
