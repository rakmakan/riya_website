import { defineField, defineType } from 'sanity';

export const service = defineType({
  name: 'service',
  title: 'Service',
  type: 'document',
  fields: [
    defineField({
      name: 'number',
      title: 'Number (e.g. "01")',
      type: 'string',
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'title',
      title: 'Service Title',
      type: 'string',
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'tagline',
      title: 'Tagline / Best for',
      type: 'string',
    }),
    defineField({
      name: 'description',
      title: 'Description',
      type: 'text',
      rows: 4,
    }),
    defineField({
      name: 'price',
      title: 'Price',
      type: 'string',
      description: 'e.g. "$500", "From $2,500", "$700"',
    }),
    defineField({
      name: 'priceNote',
      title: 'Price Note',
      type: 'string',
      description: 'e.g. "· 90 minutes · Video call + written summary"',
    }),
    defineField({
      name: 'deliverables',
      title: 'Deliverables',
      type: 'array',
      of: [{ type: 'string' }],
    }),
    defineField({
      name: 'cta',
      title: 'CTA Label',
      type: 'string',
    }),
    defineField({
      name: 'featured',
      title: 'Featured / highlighted card',
      type: 'boolean',
      initialValue: false,
    }),
    defineField({
      name: 'order',
      title: 'Display order',
      type: 'number',
    }),
  ],
  preview: {
    select: {
      title: 'title',
      subtitle: 'price',
    },
  },
});
