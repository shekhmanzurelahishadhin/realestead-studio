# Meridian — Real Estate & Construction Website

A premium, cinematic Next.js frontend for a real estate development and
construction studio, built as a foundation you can later connect to a
Laravel/API backend.

## Stack

- Next.js 15 (App Router) + TypeScript
- Tailwind CSS v4
- Framer Motion (reveals, page/menu transitions, magnetic buttons, counters)
- GSAP + ScrollTrigger (horizontal project showcase)
- Lucide React icons
- next/font (Fraunces + Instrument Sans)

## Getting started

```bash
npm install
npm run dev
```

Open http://localhost:3000.

> The first `npm install` / `npm run dev` needs an internet connection so
> `next/font` can fetch Fraunces and Instrument Sans from Google Fonts.

## Build for production

```bash
npm run build
npm start
```

## Project structure

```
src/
├── app/                  Routes (home, projects, properties, services, about, contact)
├── components/
│   ├── layout/            Navbar, Footer
│   ├── sections/          Page sections (Hero, About, Services, Process, …)
│   ├── ui/                Button, ProjectCard, PropertyCard
│   └── animations/        FadeUp, RevealText, ParallaxImage, ImageReveal,
│                           HorizontalScroll, MagneticButton, Counter,
│                           CustomCursor, SmoothLoader
├── data/                  projects.ts, properties.ts, content.ts (mock data)
├── types/                 Shared TypeScript interfaces
```

## Connecting a real backend later

All content (`projects`, `properties`, `services`, `testimonials`) lives in
`src/data/*.ts` behind the TypeScript types in `src/types/index.ts`. To go
dynamic:

1. Replace the static arrays with `fetch()` calls to your Laravel API
   (e.g. inside each page's async Server Component).
2. Keep the same shape as the `Project` / `Property` / `Service` types so no
   component code needs to change.
3. For the contact form (`src/components/sections/ContactForm.tsx`), wire the
   `handleSubmit` function to a real API route or your backend endpoint.

## Notes

- Images currently come from Unsplash for placeholder photography — swap in
  your own project/property photos in `src/data/*.ts`.
- The custom cursor and some scroll effects are automatically disabled on
  touch devices and when `prefers-reduced-motion` is set.
- Replace the map placeholders (`/contact`, property detail pages) with a
  real Google Maps embed or component when you have an API key.
