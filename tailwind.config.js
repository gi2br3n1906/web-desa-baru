/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        desaBlue: {
          DEFAULT: '#1e40af',
          dark: '#1e3a8a',
        },
        desaYellow: {
          DEFAULT: '#facc15',
          dark: '#eab308',
        },
      },
    },
  },
  plugins: [],
}

