import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

import colors from 'tailwindcss/colors';

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
                sand: {
                    ...colors.stone,
                    50: '#FDFCFB', // almost white, like pristine sand
                    100: '#F5F2EB', // white sand
                    200: '#E6DFD3', // slightly darker sand
                },
                sea: {
                    ...colors.sky,
                    100: '#E0F2FE', // very light sky blue
                    300: '#7DD3FC', // sky blue
                    900: '#0C4A6E', // deep sky/ocean blue
                }
            }
        },
    },

    plugins: [forms],
};
