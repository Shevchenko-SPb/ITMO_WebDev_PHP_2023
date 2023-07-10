/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}",
  ["./assets/js/main.js"],
  ["./app/templates/index.html"],
  ["./assets/js/**/*.{html,js}"],
  ["./app/templates/**/*.{html,js}"]],
  theme: {
    fontFamily: {
      sans: [
        "Inter var, sans-serif",
        {
          fontFeatureSettings: '"cv11", "ss01"',
          fontVariationSettings: '"opsz" 32'
        },
      ],
    },
    extend: {},
  },
  plugins: [],
}