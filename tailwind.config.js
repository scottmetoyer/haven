import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'media',

    safelist: [
        'prose',
        'prose-lg',
        'prose-xl',
        'max-w-none',
        {
            pattern: /prose-(headings|lead|h1|h2|h3|h4|p|a|blockquote|figure|figcaption|strong|em|code|pre|ol|ul|li|table|thead|tr|th|td|img|video|hr)/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
