/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*{php,html,js}","./src/*{php,html,js}"],
  theme: {
    extend: {
      height : {
        '23': '88px'
      },
      fontFamily: {
        custom: ['Poppins', 'sans-serif']
      }
    },
  },
  plugins: [],
}

