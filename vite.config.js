// vite.config.ts

import UnoCSS from 'unocss/vite'
import { presetIcons, presetUno} from "unocss"
import presetWebFonts from '@unocss/preset-web-fonts'

export default {
  // root: 'app/templates',
  plugins: [
    UnoCSS({
      include: ['./index.html', 'main.js', './src/**/**.js'],
      presets: [
        presetUno({}),
        presetIcons({}),
        presetWebFonts({
          provider: 'google', // default provider
          fonts: {
            // these will extend the default theme
            sans: 'Roboto:400,700',
            mono: ['Fira Code', 'Fira Mono:400,700'],
            // custom ones
            lobster: 'Lobster',
            lato: [
              {
                name: 'Lato',
                weights: ['400', '700'],
                italic: true,
              },
              {
                name: 'sans-serif',
                provider: 'none',
              },
            ],
          },
        })
      ], // disable //default preset

      rules: [
        // your custom rules
      ],
    }),
  ],
}