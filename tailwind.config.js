import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from "daisyui";

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
            backgroundImage: theme => ({
                'checkered-pattern': 'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIAAgMAAACJFjxpAAAACVBMVEVVVVVZWVldXV0BodFVAAABQklEQVR4Xu3YsQkAIBAEQbVHLdIqtYcLLpkHw4fho8XxZwZvxfsAAAAAAAAAO5uT7vcvAAAAAAAAAKAHAAAAAAAAAPQAAAAAAAAAgB4AAAAAAAAA0AMAAAAAAAAAegAAAAAAAABADwAAAAAAAADoAQAAAAAAAAA9AAAAAAAAAKAHAAAAAAAAAPQAAAAAAAAAgB4AAAAAAAAA0AMAAAAAAAAAegAAAAAAAABADwAAAAAAAADc8vQvAAAAAAAAAOB/AAAAAAAAAEAPAAAAAAAAAOgBAAAAAAAAAD0AAAAAAAAAoAcAAAAAAAAA9AAAAAAAAACAHgAAAAAAAADQAwAAAAAAAAB6AAAAAAAAAEAPAAAAAAAAAOgBAAAAAAAAAD0AAAAAAAAAoAcAAAAAAAAA9AAAAAAAAACAHgAAAAAAAAC45Xl8COVIQrvCeAAAAABJRU5ErkJggg==")',
            })
        },
    },

    daisyui: {
        themes: ["light", "dark", "cupcake"],
    },

    plugins: [
        forms,
        daisyui
    ],
};
