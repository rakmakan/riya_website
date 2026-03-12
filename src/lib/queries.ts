import { sanityClient, isSanityConfigured } from './sanity';

// ─── Types ────────────────────────────────────────────────────────────────────

export interface SanityTestimonial {
  _id: string;
  clientName: string;
  role: string;
  company: string;
  quote: string;
  logo?: { asset?: { _ref: string } };
  order?: number;
}

export interface SanityCaseStudy {
  _id: string;
  title: string;
  slug: { current: string };
  client: string;
  category: string;
  summary: string;
  problem: string;
  whatIDid: string;
  outcome: string;
  metrics?: string;
  order?: number;
}

export interface SanityClientLogo {
  _id: string;
  companyName: string;
  logo?: { asset?: { _ref: string } };
  order?: number;
}

export interface SanityService {
  _id: string;
  number: string;
  title: string;
  tagline?: string;
  description?: string;
  price?: string;
  priceNote?: string;
  deliverables?: string[];
  cta?: string;
  ctaHref?: string;
  featured?: boolean;
  note?: string;
  order?: number;
}

// ─── Queries ──────────────────────────────────────────────────────────────────

export async function getTestimonials(): Promise<SanityTestimonial[]> {
  if (!isSanityConfigured()) return [];
  return sanityClient.fetch(
    `*[_type == "testimonial"] | order(order asc) {
      _id, clientName, role, company, quote, logo, order
    }`
  );
}

export async function getCaseStudies(): Promise<SanityCaseStudy[]> {
  if (!isSanityConfigured()) return [];
  return sanityClient.fetch(
    `*[_type == "caseStudy"] | order(order asc) {
      _id, title, slug, client, category, summary, problem, whatIDid, outcome, metrics, order
    }`
  );
}

export async function getCaseStudyBySlug(slug: string): Promise<SanityCaseStudy | null> {
  if (!isSanityConfigured()) return null;
  const results = await sanityClient.fetch(
    `*[_type == "caseStudy" && slug.current == $slug][0] {
      _id, title, slug, client, category, summary, problem, whatIDid, outcome, metrics
    }`,
    { slug }
  );
  return results ?? null;
}

export async function getAllCaseStudySlugs(): Promise<string[]> {
  if (!isSanityConfigured()) return [];
  const results = await sanityClient.fetch(
    `*[_type == "caseStudy"]{ "slug": slug.current }`
  );
  return results.map((r: { slug: string }) => r.slug);
}

export async function getClientLogos(): Promise<SanityClientLogo[]> {
  if (!isSanityConfigured()) return [];
  return sanityClient.fetch(
    `*[_type == "clientLogo"] | order(order asc) {
      _id, companyName, logo, order
    }`
  );
}

export async function getServices(): Promise<SanityService[]> {
  if (!isSanityConfigured()) return [];
  return sanityClient.fetch(
    `*[_type == "service"] | order(order asc) {
      _id, number, title, tagline, description, price, priceNote,
      deliverables, cta, ctaHref, featured, note, order
    }`
  );
}
