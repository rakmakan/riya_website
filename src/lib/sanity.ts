import { createClient } from '@sanity/client';

export const sanityClient = createClient({
  projectId: import.meta.env.PUBLIC_SANITY_PROJECT_ID || 'placeholder',
  dataset: import.meta.env.PUBLIC_SANITY_DATASET || 'production',
  apiVersion: '2024-01-01',
  useCdn: true,
});

/** Returns true once a real project ID has been configured */
export function isSanityConfigured(): boolean {
  const id = import.meta.env.PUBLIC_SANITY_PROJECT_ID;
  return !!id && id !== 'placeholder';
}

/** Build a CDN image URL from a Sanity image reference */
export function imageUrl(source: { asset?: { _ref?: string } } | null | undefined, height = 80): string {
  if (!source?.asset?._ref) return '';
  const ref = source.asset._ref; // e.g. "image-abc123-200x200-svg"
  const [, id, dimensionsAndExt] = ref.split('-');
  const parts = dimensionsAndExt?.split('-') ?? [];
  const ext = parts[parts.length - 1] ?? 'png';
  const projectId = import.meta.env.PUBLIC_SANITY_PROJECT_ID;
  const dataset = import.meta.env.PUBLIC_SANITY_DATASET || 'production';
  return `https://cdn.sanity.io/images/${projectId}/${dataset}/${id}-${parts.slice(0, -1).join('-')}.${ext}?h=${height}&auto=format`;
}
