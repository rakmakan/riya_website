# Airy Alps — Setup Guide

## Prerequisites

Install Node.js (v20+):
```bash
# Option 1: via Homebrew (recommended for Mac)
brew install node

# Option 2: Download from nodejs.org
# https://nodejs.org/en/download
```

---

## Phase 1 — Local dev setup

```bash
# 1. Navigate to the project
cd airy-alps

# 2. Install dependencies
npm install

# 3. Copy env file and fill in values
cp .env.example .env

# 4. Start the dev server
npm run dev
# → opens at http://localhost:4321
```

The site works fully **without Sanity or Resend configured** — all content is hardcoded as static data. Hook up Sanity and Resend when you're ready.

---

## Phase 2 — Set up Sanity CMS

### 2a. Create a Sanity project

```bash
# From the airy-alps/ directory:
npm create sanity@latest -- --project-id YOUR_PROJECT_ID --dataset production --output-path ./sanity
```

Or visit [sanity.io/get-started](https://www.sanity.io/get-started) and create a project manually, then add your project ID to `.env`.

### 2b. Add your Sanity credentials to .env

```env
PUBLIC_SANITY_PROJECT_ID=abc123xyz
PUBLIC_SANITY_DATASET=production
SANITY_API_TOKEN=sk...  # create a read token in sanity.io/manage
```

### 2c. Access Sanity Studio

After setting up, visit `/studio` on your deployed site, or run:
```bash
npx sanity dev
```

### 2d. Enter content in Sanity

Add your 3 case studies, 2+ testimonials, 3 services, and 6 client logos through the Studio UI at `your-project.sanity.studio`.

### 2e. Pages switch automatically

All pages already fetch from Sanity when `PUBLIC_SANITY_PROJECT_ID` is set. If Sanity returns no data (empty project), the site falls back to the hardcoded content — so nothing breaks during setup. Once you add content in the Studio and rebuild, the live data appears automatically.

---

## Phase 3 — Set up Resend (contact form emails)

1. Sign up at [resend.com](https://resend.com) (free: 3,000 emails/month)
2. Create an API key
3. Add to `.env`:
   ```env
   RESEND_API_KEY=re_...
   CONTACT_EMAIL_TO=riyauppal777@gmail.com
   ```
4. Verify your domain in Resend so emails send from `@airyalps.com`

---

## Phase 4 — Deploy to Cloudflare Pages

### 4a. Push to GitHub

```bash
git init
git add .
git commit -m "Initial Astro build"
git remote add origin https://github.com/yourusername/airy-alps.git
git push -u origin main
```

### 4b. Connect to Cloudflare Pages

1. Go to [pages.cloudflare.com](https://pages.cloudflare.com)
2. Create a new project → connect GitHub repo
3. Build settings:
   - **Framework preset:** Astro
   - **Build command:** `npm run build`
   - **Build output:** `dist`
4. Add environment variables (same as `.env`):
   - `PUBLIC_SANITY_PROJECT_ID`
   - `PUBLIC_SANITY_DATASET`
   - `SANITY_API_TOKEN`
   - `RESEND_API_KEY`
   - `CONTACT_EMAIL_TO`

### 4c. Custom domain

In Cloudflare Pages → Custom domains → Add `airyalps.com`

---

## Phase 5 — Add calendar link

Once you have a Calendly or Cal.com link:

1. In Sanity Studio → Site Settings → "Book a Call calendar link"
2. The contact page currently shows "Calendar link coming soon — use the form for now."
3. Update `src/pages/contact.astro` line ~114 to use the Sanity `calendarLink` field

---

## Content gaps to resolve before launch

| Item | Status | Where to fix |
|---|---|---|
| AI platform name | ❓ Needs name/description | `src/pages/index.astro` — solution section |
| Calendar link (Calendly/Cal.com) | ❓ Needs link | Sanity → Site Settings |
| Case study client names | ❓ Confirm named vs anonymous | Sanity → Case Studies → `client` field |

---

## Build verification checklist

- [ ] `npm run build` — zero errors
- [ ] All 5 pages render: `/`, `/about`, `/work-with-me`, `/case-studies`, `/contact`
- [ ] 3 case study detail pages render: `/case-studies/stalled-to-shipped`, etc.
- [ ] Contact form submits and sends email
- [ ] Sanity Studio accessible at `/studio`
- [ ] Redirects work: `/skills` → `/about`, `/work` → `/about`
- [ ] Mobile layout on all 5 pages
- [ ] Lighthouse: target 95+ Performance, 100 Accessibility, 100 SEO

---

## Project structure

```
airy-alps/
├── src/
│   ├── pages/
│   │   ├── index.astro              # Homepage
│   │   ├── about.astro              # About
│   │   ├── work-with-me.astro       # Services + pricing
│   │   ├── case-studies/
│   │   │   ├── index.astro          # Listing
│   │   │   └── [slug].astro         # Dynamic case study
│   │   ├── contact.astro            # Contact + form
│   │   ├── 404.astro                # 404 page
│   │   └── api/
│   │       └── contact.ts           # Form → Resend email API
│   ├── components/
│   │   ├── Header.astro             # Fixed nav with mobile menu
│   │   ├── Footer.astro             # Footer with entity paragraph
│   │   ├── TestimonialSwiper.astro  # Swiper.js carousel
│   │   ├── CaseStudyCard.astro      # Card component
│   │   └── PricingCard.astro        # Pricing card
│   ├── layouts/
│   │   └── BaseLayout.astro         # Head, header, footer, Lenis, GSAP
│   └── styles/
│       └── global.css               # Tailwind + CSS variables + noise texture
├── sanity/
│   ├── schemaTypes/
│   │   ├── caseStudy.ts
│   │   ├── testimonial.ts
│   │   ├── service.ts
│   │   ├── client.ts
│   │   └── siteSettings.ts
│   └── sanity.config.ts
├── public/
│   ├── favicon.svg
│   └── _redirects                   # /skills → /about, /work → /about
├── astro.config.mjs
├── tailwind.config.mjs
├── package.json
└── .env.example
```
