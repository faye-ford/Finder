/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                rose: {
                    50: '#fdf2f8',
                    100: '#fce7f3',
                    200: '#fbcfe8',
                    400: '#f472b6',
                    500: '#ec4899',
                    600: '#db2777',
                    700: '#be185d',
                },
                purple: {
                    50: '#faf5ff',
                    100: '#f3e8ff',
                    200: '#e9d5ff',
                    400: '#a78bfa',
                    500: '#a855f7',
                    600: '#9333ea',
                    700: '#7e22ce',
                },
                fuchsia: {
                    50: '#fdf4ff',
                    100: '#fce7fe',
                    200: '#f8d7fe',
                    400: '#d946ef',
                    500: '#d946ef',
                    600: '#c026d3',
                    700: '#a21caf',
                },
            },
            fontFamily: {
                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}
