/**
 * Seed Sanity with all hardcoded website content.
 * Run: node scripts/seed-sanity.mjs
 */

import { createClient } from '@sanity/client';
import * as dotenv from 'dotenv';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: resolve(__dirname, '../.env') });

const client = createClient({
  projectId: process.env.PUBLIC_SANITY_PROJECT_ID,
  dataset: process.env.PUBLIC_SANITY_DATASET || 'production',
  token: process.env.SANITY_API_TOKEN,
  apiVersion: '2024-01-01',
  useCdn: false,
});

// ── Case Studies ──────────────────────────────────────────────────────────────

const caseStudies = [
  {
    _type: 'caseStudy',
    _id: 'case-study-stalled-to-shipped',
    title: 'From Stalled to Shipped: Unblocking a Website After a Year-Long Standstill',
    slug: { _type: 'slug', current: 'stalled-to-shipped' },
    client: 'Technology Company (name available on request)',
    category: 'Brand Architecture',
    summary: "A technology company's website had been stuck in limbo for over 12 months. Multiple teams, competing opinions, and no clear messaging architecture. A positioning-first rewrite unblocked everything within weeks.",
    problem: "A technology company's website had been stuck in limbo for over 12 months. Multiple teams, competing opinions, and no clear messaging architecture. The project was stalled — and it was costing the business.\n\nThe real issue wasn't design or development. The site was trying to speak to two completely different audiences — founders and enterprise procurement leads — with one unfocused message. Nobody was willing to say it out loud.",
    whatIDid: "Ran stakeholder workshops to surface the real positioning decisions that needed to be made. Rewrote the entire site from a clear messaging hierarchy — one that addressed both audiences without diluting the core message. Built a content structure that could scale as the company grew.",
    outcome: "Site launched within weeks of my involvement. On-site conversion improved, time on page increased, and SEMrush authority score reached 80+.",
    metrics: '18% increase in time on page · SEMrush authority score 80+',
  },
  {
    _type: 'caseStudy',
    _id: 'case-study-crm-precision-messaging',
    title: 'No More Spray and Pray: How CRM Data Turned Generic Outreach into Targeted Wins',
    slug: { _type: 'slug', current: 'crm-precision-messaging' },
    client: 'B2B Technology Company (name available on request)',
    category: 'Messaging Strategy',
    summary: "A B2B company's outreach campaigns were casting a wide net and catching very little. By mapping CRM data to real buyer psychology, precision targeting replaced volume spray — and the sales team adopted the new framework as their default.",
    problem: "A B2B company was running outreach campaigns that cast a wide net and caught very little. High volume, low conversion, frustrated sales team.\n\nThe messaging was product-first, not buyer-first. There was no differentiation between segments — everyone got the same pitch regardless of where they were, what they cared about, or what stage they were at.",
    whatIDid: "Mapped the CRM data to real buyer behaviors and pain points. Built distinct positioning for each segment. Rewrote outreach sequences so every message spoke directly to a specific trigger, tension, and outcome.",
    outcome: "Precision targeting replaced volume spray. Two major account wins attributed directly to the repositioned sequences. Sales team adopted the new framework as their default.",
    metrics: '2 major account wins attributed to repositioned sequences · Framework adopted as sales team standard',
  },
  {
    _type: 'caseStudy',
    _id: 'case-study-cold-email-repositioning',
    title: 'Strategy Before Send: Turning Cold Emails into Warm Leads',
    slug: { _type: 'slug', current: 'cold-email-repositioning' },
    client: 'B2B Platform (name available on request)',
    category: 'Cold Outreach Repositioning',
    summary: "Cold email campaigns for a B2B platform were generating opens but no replies. Rebuilding buyer personas from scratch and repositioning around actual buyer tension — not product features — changed everything.",
    problem: "Cold email campaigns for a B2B platform were generating opens but no replies. The pipeline was stalled at the top.\n\nThe emails led with features. Nobody cared. The real pain point — the reason anyone would actually stop scrolling and reply — was buried or missing entirely.",
    whatIDid: "Rebuilt buyer personas from scratch. Repositioned the messaging around the tension buyers were actually feeling, not the product capabilities. Rewrote email sequences with short, sharp copy built around a single, relevant idea per email.",
    outcome: "Open rates held. Reply rates increased. Pipeline quality improved — fewer time-wasters, more qualified conversations.",
    metrics: 'Increased reply rates · Improved pipeline quality',
  },
];

// ── Testimonials ──────────────────────────────────────────────────────────────

const testimonials = [
  {
    _type: 'testimonial',
    _id: 'testimonial-paras-gang',
    clientName: 'Paras Gang',
    role: 'Founder',
    company: 'Griphhy',
    quote: 'She brought a rare combination of analytical insight and bold creativity. Her ability to craft compelling brand narratives while driving measurable digital growth made a significant impact.',
  },
  {
    _type: 'testimonial',
    _id: 'testimonial-manisha-dubey',
    clientName: 'Manisha Dubey',
    role: 'VP Marketing',
    company: 'IDEMIA',
    quote: 'Riya is brilliant at creating internal as well as external communications. She has a good understanding of technology and does a great job defining the target audience.',
  },
  {
    _type: 'testimonial',
    _id: 'testimonial-karan-sharma',
    clientName: 'Karan Sharma',
    role: 'Founder',
    company: 'Hubsell',
    quote: 'I highly recommend Riya to anybody needing help in marketing, corporate communications and PR. She is a self-starter with commendable storytelling, analytical and writing skills — all of which make her an excellent marketer.',
  },
];

// ── Services ──────────────────────────────────────────────────────────────────

const services = [
  {
    _type: 'service',
    _id: 'service-positioning-audit',
    title: 'Positioning Audit',
    tagline: 'Best for founders who want clarity before committing to a full engagement',
    price: '$500',
    priceNote: '· 90 min · Video call + written summary',
    description: "You're getting traction but something in your messaging isn't landing. You can feel the gap — you just can't name it. In 90 minutes, we dig into your brand, your audience, your current positioning, and your content.",
  },
  {
    _type: 'service',
    _id: 'service-narrative-foundation-sprint',
    title: 'Narrative Foundation Sprint',
    tagline: 'Best for founders ready to build their positioning foundation and execution system',
    price: 'From $2,500',
    priceNote: '· 3–4 weeks · Done-with-you',
    description: 'The full build. Over 3–4 weeks, we work together to build the complete narrative foundation your brand has been missing — and I set up the AI-powered system that executes it for you every week.',
  },
  {
    _type: 'service',
    _id: 'service-monthly-advisory',
    title: 'Monthly Positioning Advisory',
    tagline: 'Best for Sprint alumni who want ongoing strategic support as they grow',
    price: '$700',
    priceNote: '/ month · Cancel anytime',
    description: "Your positioning isn't static. As your business evolves, your message needs to keep up. Available to Narrative Foundation Sprint clients only.",
  },
];

// ── Client Logos ──────────────────────────────────────────────────────────────

const clientLogos = [
  { _type: 'clientLogo', _id: 'client-parimatch',  companyName: 'Parimatch'     },
  { _type: 'clientLogo', _id: 'client-cladiator',  companyName: 'Cladiator'     },
  { _type: 'clientLogo', _id: 'client-hubsell',    companyName: 'Hubsell'       },
  { _type: 'clientLogo', _id: 'client-opensense',  companyName: 'OpenSense Labs' },
  { _type: 'clientLogo', _id: 'client-idemia',     companyName: 'IDEMIA'        },
  { _type: 'clientLogo', _id: 'client-griphhy',    companyName: 'Griphhy'       },
  { _type: 'clientLogo', _id: 'client-storied',    companyName: 'Storied Inc'   },
  { _type: 'clientLogo', _id: 'client-preipohype', companyName: 'Pre IPO Hype'  },
];

// ── Seed ──────────────────────────────────────────────────────────────────────

async function seed() {
  const allDocs = [...caseStudies, ...testimonials, ...services, ...clientLogos];

  console.log(`Seeding ${allDocs.length} documents to Sanity project ${process.env.PUBLIC_SANITY_PROJECT_ID}...\n`);

  const transaction = client.transaction();
  for (const doc of allDocs) {
    transaction.createOrReplace(doc);
  }

  await transaction.commit();

  console.log('✓ Case Studies:  ', caseStudies.length);
  console.log('✓ Testimonials:  ', testimonials.length);
  console.log('✓ Services:      ', services.length);
  console.log('✓ Client Logos:  ', clientLogos.length);
  console.log('\nDone! Refresh Sanity Studio to see your content.');
}

seed().catch((err) => {
  console.error('Seed failed:', err.message);
  process.exit(1);
});
