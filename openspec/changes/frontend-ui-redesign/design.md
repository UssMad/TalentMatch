## Context

TalentMatch currently uses default Laravel Breeze styling — generic gray/indigo theme, placeholder dashboard, basic welcome page. The frontend stack is Tailwind CSS v3, Alpine.js v3, Blade, and Vite. There is no custom CSS, no brand identity, and all views are server-rendered.

## Goals / Non-Goals

**Goals:**
- Create a professional brand identity with a custom color palette and design tokens
- Redesign all UI views to feel modern, polished, and consistent
- Replace the placeholder dashboard with recruitment KPIs and actionable metrics
- Build an engaging landing/welcome page that communicates product value
- Enhance the navigation with icons and clearer hierarchy
- Improve accessibility, responsive behavior, and micro-interactions
- Maintain full dark mode support across all new styles

**Non-Goals:**
- No migration to Livewire, Inertia, or SPA — all views stay server-rendered Blade
- No backend API changes or new database tables
- No new JavaScript build tools or frameworks beyond existing Alpine.js + Tailwind
- No changes to the AI agent, tools, or conversational logic
- No restructuring of routes, controllers, or backend architecture

## Decisions

1. **Brand color palette**: Custom brand colors will be defined in `tailwind.config.js` using a professional indigo/blue primary palette (`brand-*`), with semantic accent colors for success (green), warning (amber), danger (red), and info (sky). This replaces the stock Tailwind `indigo` as the primary accent.

2. **Navigation**: The current top navbar will be enhanced with SVG icons (using Heroicons inline) for each nav link, a visual active state indicator, and a compact mobile drawer. A secondary sidebar navigation is not introduced to avoid layout complexity — the top nav remains the primary navigation pattern.

3. **Dashboard**: The placeholder dashboard will be replaced with a grid of KPI stat cards (total candidates, job offers, analyses, avg match rate), a recent activity table, and quick-action cards. KPI data will be queried via the existing `DashboardController` (to be updated) using Eloquent aggregate queries.

4. **Landing page**: The welcome page will become a full marketing landing page with hero section, feature highlight cards, stats bar, and CTA section. The existing auth links (Login/Register) will remain in the top-right corner. All styling uses custom brand tokens.

5. **Component architecture**: Rather than creating a heavy component library, the redesign relies on enhanced Tailwind utility patterns and the existing Blade X-components (buttons, inputs, cards) which will be updated with new default styles. New shared patterns (stat cards, KPIs, data tables) will use Blade includes or inline markup.

6. **Dark mode peristence**: Dark mode detection remains system-preference based via Tailwind's `darkMode: 'class'` (already configured via Breeze). The color palette includes dark variants for all new tokens.

7. **Micro-interactions**: Subtle hover transitions (`transition-all duration-200`), focus rings using brand colors, and Alpine.js for interactive elements like the mobile menu. No heavy animation libraries.

## Risks / Trade-offs

- **Risk**: Custom brand tokens increase maintenance surface if design changes later → Mitigation by keeping tokens in one central location (`tailwind.config.js` theme extend)
- **Risk**: Updating all views simultaneously is a large surface area → Mitigation by implementing view-by-view in priority order (layout → dashboard → landing → job offers → candidates → chat → auth)
- **Risk**: Dark mode colors may not be perfectly balanced without visual QA → Trade-off accepted; colors will follow Tailwind's dark variant conventions and can be tuned later
- **Trade-off**: No sidebar navigation keeps the UI simpler but may limit scalability if many nav items are added later
