/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './app/views/**/*.php',
    './public/*.php',
    './public/assets/js/**/*.js',
    './public/assets/css/**/*.css' // Added this line
  ],
  theme: {
    extend: {}
  },
  plugins: []
}
