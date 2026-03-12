import { defineConfig } from 'astro/config';
import tailwind from '@astrojs/tailwind';
import sanity from '@sanity/astro';
import cloudflare from '@astrojs/cloudflare';

export default defineConfig({
  // 'static' is the default in Astro v5; API routes opt-in via `export const prerender = false`
  output: 'static',
  adapter: cloudflare(),
  integrations: [
    tailwind(),
    sanity({
      // These are read at build time from .env
      projectId: process.env.PUBLIC_SANITY_PROJECT_ID || 'placeholder',
      dataset: process.env.PUBLIC_SANITY_DATASET || 'production',
      useCdn: true,
      studioBasePath: '/studio',
    }),
  ],
});
