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
                sans: ['Montserrat', 'Inter', ...defaultTheme.fontFamily.sans],
                display: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Bandage Primary - Bright Blue
                primary: {
                    50: '#e6f7ff',
                    100: '#b3e5ff',
                    200: '#80d4ff',
                    300: '#4dc2ff',
                    400: '#1ab1ff',
                    500: '#23A6F0', // Bandage Blue
                    600: '#1a8fcc',
                    700: '#1478a9',
                    800: '#0d6085',
                    900: '#074962',
                },
                // Bandage Secondary - Teal Green
                secondary: {
                    50: '#e6f5f2',
                    100: '#b3e0d9',
                    200: '#80cbbf',
                    300: '#4db6a6',
                    400: '#1aa18c',
                    500: '#23856D', // Bandage Teal
                    600: '#1c6a57',
                    700: '#165041',
                    800: '#0f352b',
                    900: '#091b15',
                },
                // Success - Green
                success: {
                    50: '#e8f7f0',
                    100: '#bfe9d5',
                    200: '#95dbb9',
                    300: '#6ccd9d',
                    400: '#42bf81',
                    500: '#2DC071', // Bandage Success Green
                    600: '#249a5a',
                    700: '#1b7443',
                    800: '#124d2d',
                    900: '#092716',
                },
                // Warning - Orange
                warning: {
                    50: '#fef3ea',
                    100: '#fcdec3',
                    200: '#fac99c',
                    300: '#f8b475',
                    400: '#f69f4e',
                    500: '#E77C40', // Bandage Orange
                    600: '#c5632d',
                    700: '#944a22',
                    800: '#633116',
                    900: '#32180b',
                },
                // Danger - Red
                danger: {
                    50: '#feeaea',
                    100: '#fbc3c3',
                    200: '#f89c9c',
                    300: '#f57575',
                    400: '#f24e4e',
                    500: '#E74040', // Bandage Red
                    600: '#c23030',
                    700: '#912424',
                    800: '#611818',
                    900: '#300c0c',
                },
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '100': '25rem',
                '128': '32rem',
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'medium': '0 4px 20px -2px rgba(0, 0, 0, 0.1), 0 15px 30px -3px rgba(0, 0, 0, 0.08)',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.4s ease-out',
                'scale-in': 'scaleIn 0.3s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                scaleIn: {
                    '0%': { transform: 'scale(0.95)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
            },
        },
    },

    plugins: [forms],
};
