const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#0099CC',
                    50: '#E6F7FF',
                    100: '#CCF0FF',
                    200: '#99E0FF',
                    300: '#66D1FF',
                    400: '#33C1FF',
                    500: '#0099CC',
                    600: '#007AA3',
                    700: '#005C7A',
                    800: '#003D52',
                    900: '#001F29',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
