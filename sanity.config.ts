import { defineConfig } from 'sanity';
import { structureTool } from 'sanity/structure';
import { schemaTypes } from './sanity/schemaTypes';

export default defineConfig({
  name: 'airy-alps',
  title: 'Airy Alps CMS',

  projectId: import.meta.env.PUBLIC_SANITY_PROJECT_ID ?? '8chfwd64',
  dataset: import.meta.env.PUBLIC_SANITY_DATASET ?? 'production',

  plugins: [
    structureTool({
      structure: (S) =>
        S.list()
          .title('Content')
          .items([
            S.listItem()
              .title('Site Settings')
              .id('siteSettings')
              .child(
                S.document()
                  .schemaType('siteSettings')
                  .documentId('siteSettings')
              ),
            S.divider(),
            S.documentTypeListItem('caseStudy').title('Case Studies'),
            S.documentTypeListItem('testimonial').title('Testimonials'),
            S.documentTypeListItem('service').title('Services'),
            S.documentTypeListItem('clientLogo').title('Client Logos'),
          ]),
    }),
  ],

  schema: {
    types: schemaTypes,
  },
});
