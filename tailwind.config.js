import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  important: true,
  content: [
    "./vendor/laravel/framework/src/**/*.blade.php",
    "./storage/framework/views/**/*.php",
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Poppins", ...defaultTheme.fontFamily.sans],
      },
      width: {
        'nump': '20%',
      },
      maxHeight: {
        '120': '440px',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    forms,
  ],
}

