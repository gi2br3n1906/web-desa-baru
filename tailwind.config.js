/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: [
    'line-through',
    'opacity-50',
    'cursor-not-allowed',
    'ml-1',
    'inline-block',
    'no-underline',
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

