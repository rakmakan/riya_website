import { defineField, defineType } from 'sanity';

export const siteSettings = defineType({
  name: 'siteSettings',
  title: 'Site Settings',
  type: 'document',
  // Singleton — only one document of this type should exist
  __experimental_actions: ['update', 'publish'],
  fields: [
    defineField({
      name: 'heroTitle',
      title: 'Hero H1 (Homepage)',
      type: 'string',
    }),
    defineField({
      name: 'heroSubtitle',
      title: 'Hero Subhead (Homepage)',
      type: 'text',
      rows: 3,
    }),
    defineField({
      name: 'metaDescriptionHome',
      title: 'Meta description — Home',
      type: 'text',
      rows: 2,
      validation: (rule) => rule.max(160),
    }),
    defineField({
      name: 'metaDescriptionAbout',
      title: 'Meta description — About',
      type: 'text',
      rows: 2,
      validation: (rule) => rule.max(160),
    }),
    defineField({
      name: 'metaDescriptionWork',
      title: 'Meta description — Work With Me',
      type: 'text',
      rows: 2,
      validation: (rule) => rule.max(160),
    }),
    defineField({
      name: 'calendarLink',
      title: 'Book a Call calendar link',
      type: 'url',
      description: 'Calendly or Cal.com URL for the "Book a Free Call" CTA',
    }),
    defineField({
      name: 'linkedinUrl',
      title: 'LinkedIn URL',
      type: 'url',
    }),
    defineField({
      name: 'emailAddress',
      title: 'Contact email',
      type: 'string',
    }),
  ],
  preview: {
    select: {
      title: 'heroTitle',
    },
    prepare() {
      return { title: 'Site Settings' };
    },
  },
});
