import { defineField, defineType } from 'sanity';

export const caseStudy = defineType({
  name: 'caseStudy',
  title: 'Case Study',
  type: 'document',
  fields: [
    defineField({
      name: 'title',
      title: 'Title',
      type: 'string',
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'slug',
      title: 'Slug',
      type: 'slug',
      options: { source: 'title', maxLength: 96 },
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'client',
      title: 'Client',
      type: 'string',
      description: 'Client name or anonymized description (e.g. "Technology Company (name available on request)")',
    }),
    defineField({
      name: 'category',
      title: 'Category',
      type: 'string',
      options: {
        list: [
          'Brand Architecture',
          'Messaging Strategy',
          'Cold Outreach Repositioning',
          'Content Strategy',
          'Market Positioning',
        ],
      },
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'summary',
      title: 'Summary',
      type: 'text',
      rows: 3,
      description: 'Short summary shown on card and in meta description',
      validation: (rule) => rule.required().max(300),
    }),
    defineField({
      name: 'problem',
      title: 'The Situation / Problem',
      type: 'text',
      rows: 5,
      description: 'Describe the client situation and positioning problem. Use double newlines for paragraphs.',
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'whatIDid',
      title: 'What I Did',
      type: 'text',
      rows: 5,
      description: 'Plain text description of the approach taken',
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'outcome',
      title: 'The Outcome',
      type: 'text',
      rows: 4,
      description: 'The measurable result',
      validation: (rule) => rule.required(),
    }),
    defineField({
      name: 'metrics',
      title: 'Key Metric (one line)',
      type: 'string',
      description: 'e.g. "18% increase in time on page · SEMrush authority score 80+"',
    }),
    defineField({
      name: 'featured_image',
      title: 'Featured Image',
      type: 'image',
      options: { hotspot: true },
    }),
    defineField({
      name: 'featured',
      title: 'Feature on homepage',
      type: 'boolean',
      initialValue: false,
    }),
    defineField({
      name: 'order',
      title: 'Display order',
      type: 'number',
      description: 'Lower numbers appear first',
    }),
  ],
  orderings: [
    {
      title: 'Display Order',
      name: 'orderAsc',
      by: [{ field: 'order', direction: 'asc' }],
    },
  ],
  preview: {
    select: {
      title: 'title',
      subtitle: 'category',
      media: 'featured_image',
    },
  },
});
