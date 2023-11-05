import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors:{
                "hover": "#208c7b"
            },
        },
    },

    daisyui: {
        themes: [
          {
            mytheme: {
                "primary": "#116d6e",
                "secondary": "#eee8a9",
                "accent": "#00c9d0",
                "neutral": "#e6f4f1",
                "base-100": "#ffffff",
                "info": "#00708a",
                "success": "#36d399",
                "warning": "#fbbd23",
                "error": "#f87272",
            },
          },
        ],
      },

    plugins: [forms, require("daisyui")],
};
