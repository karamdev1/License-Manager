/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0d6efd',
        secondary: {
          DEFAULT: '#6c757d',
          light: 'rgb(226, 227, 229)',
        },
        dark: {
          DEFAULT: 'oklch(27.4% 0.006 286.033)',
          border: '#e6e6e6',
          text: '#666666',
        },
        light: {
          DEFAULT: 'whitesmoke',
        },
        colors: {
          green: 'oklch(76.8% 0.233 130.85)',
          red: 'oklch(57.7% 0.245 27.325)',
          yellow: 'oklch(90.5% 0.182 98.111)',
        }
      },
      blur: {
        DEFAULT: '3px',
        none: '0px',
      },
      spacing: {
        128: '32rem',
      },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [require('tailwind-scrollbar')],
};
