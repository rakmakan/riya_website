import { defineField, defineType } from 'sanity';

export const clientLogo = defineType({
  name: 'clientLogo',
  title: 'Client Logo',
  type: 'document',
  fields: [
    defineField({
      name: 'companyName',
      title: 'Company Name',
      type: 'string',
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'logo',
      title: 'Logo (SVG or PNG)',
      type: 'image',
      options: { hotspot: false },
    }),
    defineField({
      name: 'url',
      title: 'Company URL (optional)',
      type: 'url',
    }),
    defineField({
      name: 'order',
      title: 'Display order',
      type: 'number',
    }),
  ],
  preview: {
    select: {
      title: 'companyName',
      media: 'logo',
    },
  },
});
