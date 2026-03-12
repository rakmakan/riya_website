/** @type {import('tailwindcss').Config} */
export default {
  content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],
  theme: {
    extend: {
      fontFamily: {
        cormorant: ['"Cormorant Garamond"', 'serif'],
        jost: ['Jost', 'sans-serif'],
      },
      colors: {
        parchment: '#FAF7F2',
        espresso:  '#1C1512',
        sienna:    '#C4603A',
        sand:      '#E8D5C4',
        taupe:     '#8C7B70',
        mahogany:  '#2C1F18',
      },
    },
  },
  plugins: [],
};
