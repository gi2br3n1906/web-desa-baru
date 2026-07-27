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
          DEFAULT: '#1E3A8A',
          dark: '#172554',
          light: '#EFF6FF',
        },
        desaYellow: {
          DEFAULT: '#F59E0B',
          dark: '#D97706',
          light: '#FFFBEB',
        },
      },
    },
  },
  plugins: [],
}

