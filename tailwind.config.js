/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.{html,js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0d6efd',
        secondary: '#6c757d',
        dark: '#212529',
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
