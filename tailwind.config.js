/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: 'jit',
  content: [
    './app/views/**/*.php',
    './public/*.php',
    './public/assets/js/**/*.js',
    './public/assets/css/**/*.css' // Added this line
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: [
          'Roboto',
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          'Segoe UI',
          'Roboto',
          'Helvetica Neue',
          'Arial',
          'sans-serif'
        ],
        heading: [
          'Montserrat',
          'Georgia',
          'Cambria',
          'Times New Roman',
          'serif'
        ],
        mono: ['Consolas', 'Monaco', 'Andale Mono', 'Ubuntu Mono', 'monospace']
      },
      fontSize: {
        xs: '.75rem',
        sm: '.875rem',
        base: '1rem',
        lg: '1.125rem',
        xl: '1.25rem',
        '2xl': '1.5rem',
        '3xl': '1.875rem',
        '4xl': '2.25rem',
        '5xl': '3rem'
      },
      fontWeight: {
        light: 300,
        normal: 400,
        medium: 500,
        semibold: 600,
        bold: 700
      },
      container: {
        center: true,
        padding: {
          DEFAULT: '1rem',
          sm: '1rem',
          md: '1.5rem',
          lg: '2rem',
          xl: '2.5rem',
          '2xl': '3rem',
          '3xl': '4rem'
        },
        screens: {
          sm: '640px',
          md: '768px',
          lg: '1024px',
          xl: '1280px',
          '2xl': '1360px',
          '3xl': '1600px'
        }
      }
    }
  },
  plugins: []
}
