/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#00AFF0',
                blue: {
                    50: '#E1F5FE',
                    100: '#B3E5FC',
                    200: '#81D4FA',
                    300: '#4FC3F7',
                    400: '#29B6F6',
                    500: '#03A9F4',
                    600: '#00AFF0', // Skype Blue as 600
                    700: '#0288D1',
                    800: '#0277BD',
                    900: '#01579B',
                }
            }
        },
    },
    plugins: [],
};

