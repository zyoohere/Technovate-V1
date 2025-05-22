import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Inter", ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: "#008C8C",
                secondary: "#00D08C",
                dark: "#003333",
                light: "#F9F9F9",
                neutral: "#E0E0E0",
                danger: "#FF4D4F",
            },
        },
    },

    plugins: [forms],
};
