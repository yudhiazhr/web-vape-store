/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.{html,js,php}",
    "./layouts/**/*.php"
  ],
  theme: {
    container: {
      center: true,
      padding: '20px',
    },
    extend: {
      colors: {
        primary: '#2563eb',
        secondary: '#64748b',
        dark: '#0f172a',
        light: '#fff',
        bluegray: '#2d537c',
        bluedark: '#093058'
        
      },
      screens: {
        '2xl' : '1320px'
      }
    },
  },
  plugins: [],
}

