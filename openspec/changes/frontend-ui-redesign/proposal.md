## Why

TalentMatch currently uses the default Laravel Breeze starter theme — generic gray/indigo colors, stock card layouts, a placeholder dashboard ("You're logged in!"), and no brand identity. As an AI-powered recruitment platform, the UI should feel modern, polished, and trustworthy to impress clients and candidates alike. A beautiful, professional design improves perceived product quality and user trust.

## What Changes

- Introduce a custom brand design system (color palette, typography, spacing, component styles)
- Replace the placeholder dashboard with real recruitment KPIs and metrics
- Restyle the welcome/landing page to showcase TalentMatch's value
- Redesign the main navigation with icons and improved visual hierarchy
- Apply the new design system across all existing views (candidates, job offers, chat, auth)
- Add micro-interactions, transitions, and responsive polish
- Keep dark mode support throughout
- No new backend features — this is purely a frontend/UI change
- All views remain server-rendered Blade (no Livewire or Inertia migration)

## Capabilities

### New Capabilities
- `app-design-system`: Custom brand identity, design tokens (colors, fonts, shadows), reusable UI component library, layout shell enhancements
- `dashboard-metrics`: Dashboard with recruitment KPIs (total candidates, offers, analyses, match rates), recent activity feed, quick-action cards
- `landing-page`: Modern welcome page with product value proposition, feature highlights, and CTAs

### Modified Capabilities
- `job-offer-ui`: Updated job offer list/show views using new design system
- `candidate-crud`: Updated candidate list/show views with new design system and improved layout
- `conversational-agent`: Redesigned chat UI with message bubbles, avatars, and improved input

## Impact

- `resources/views/` — all Blade view files will be updated with new Tailwind classes and layouts
- `resources/css/app.css` — may add custom CSS for animations or complex styles beyond Tailwind
- `tailwind.config.js` — will extend with brand colors, fonts, and custom theme values
- `resources/js/app.js` — may add Alpine.js enhancements for interactive UI elements
- No backend, database, or API changes
- No new dependencies — uses existing Tailwind, Alpine.js, and Vite stack
