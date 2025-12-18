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
        secondary: '#6c757d',
        dark: {
          DEFAULT: 'oklch(27.4% 0.006 286.033)',
          '1': 'oklch(21% 0.006 285.885)',
          '2': 'oklch(37% 0.013 285.805)',
          '3': 'oklch(43.9% 0 0)',
        },
        smoke: 'whitesmoke',
      },
      blur: {
        DEFAULT: '3px',
        'none': '0px',
      },
      spacing: {
        128: '32rem',
      },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
    },
  },
};
