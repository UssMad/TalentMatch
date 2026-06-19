## 1. Design System Setup

- [x] 1.1 Extend `tailwind.config.js` with brand color palette (brand-50 through brand-950) and semantic accent colors
- [x] 1.2 Add any custom CSS transitions or keyframe animations in `resources/css/app.css`
- [x] 1.3 Run `npm run build` to verify Tailwind compiles with new tokens

## 2. Navigation & Layout

- [x] 2.1 Add SVG icons (Heroicons inline) to each nav link in `layouts/navigation.blade.php`
- [x] 2.2 Add visual active state indicator to nav links (underline or background highlight)
- [x] 2.3 Ensure mobile hamburger menu collapses/expands correctly with Alpine.js
- [x] 2.4 Apply brand colors to nav bar background, text, and hover states
- [x] 2.5 Update the user dropdown menu with brand styling

## 3. Brand-styled Components

- [x] 3.1 Update `primary-button` component to use brand colors (`bg-brand-600`, hover, focus)
- [x] 3.2 Update `secondary-button` component to use outlined brand style
- [x] 3.3 Update `danger-button` component to use semantic red colors
- [x] 3.4 Update `text-input` component focus ring to use brand color
- [x] 3.5 Update `input-label` and `input-error` components for brand consistency
- [x] 3.6 Update `nav-link` and `responsive-nav-link` components for active state and brand hover
- [x] 3.7 Update `dropdown` and `dropdown-link` components for brand styling

## 4. Dashboard Page

- [x] 4.1 Update `DashboardController` to query aggregate KPI data (total candidates, offers, analyses, avg score)
- [x] 4.2 Create stat card partial for displaying KPI metrics with icons and brand styling
- [x] 4.3 Replace dashboard content in `dashboard.blade.php` with KPI stat cards grid
- [x] 4.4 Add recent activity table showing latest 5 analyses with candidate name, offer title, score, recommendation
- [x] 4.5 Add quick-action cards (Create Job Offer, View Candidates, Run Analysis)
- [x] 4.6 Handle empty states for all dashboard sections

## 5. Landing Page

- [x] 5.1 Replace `welcome.blade.php` hero section with branded hero (product name, tagline, description, CTA buttons)
- [x] 5.2 Add feature highlight cards section (AI analysis, matching scores, conversational agent)
- [x] 5.3 Add statistics bar section with aggregate platform metrics
- [x] 5.4 Ensure landing page is fully responsive across mobile, tablet, and desktop
- [x] 5.5 Ensure landing page uses brand color palette

## 6. Update Job Offer Views

- [x] 6.1 Update `job-offers/index.blade.php` to use brand-styled card layout and tag pills
- [x] 6.2 Update `job-offers/show.blade.php` to use brand-styled detail cards and skill badges
- [x] 6.3 Update `job-offers/create.blade.php` and `edit.blade.php` forms with brand-styled inputs and buttons
- [x] 6.4 Update empty states in job offer views with brand styling

## 7. Update Candidate Views

- [x] 7.1 Update `candidates/index.blade.php` to use brand-styled cards with candidate info and actions
- [x] 7.2 Update `candidates/show.blade.php` with brand-styled layout, badges, and color-coded score section
- [x] 7.3 Update `candidates/create.blade.php` and `edit.blade.php` forms with brand-styled inputs and buttons
- [x] 7.4 Ensure AI analysis section on show page uses brand-styled badges and organized layout

## 8. Update Chat Views

- [x] 8.1 Update `chat/show.blade.php` message bubbles with brand-styled user messages and neutral assistant messages
- [x] 8.2 Add timestamps to each chat message bubble
- [x] 8.3 Update `chat/index.blade.php` conversation list with brand-styled cards
- [x] 8.4 Update the chat input form with brand-styled textarea and send button

## 9. Update Auth & Profile Views

- [x] 9.1 Update auth views (login, register, forgot-password, etc.) with brand-styled cards and buttons
- [x] 9.2 Update profile edit view with brand-styled form sections
- [x] 9.3 Update profile partials with brand styling

## 10. Polish & Verification

- [x] 10.1 Run `vendor/bin/pint --format agent` to fix any PHP formatting issues
- [x] 10.2 Run `npm run build` to verify frontend assets compile
- [x] 10.3 Run `php artisan test --compact` to verify all existing tests pass
- [x] 10.4 Visually verify that all pages render correctly with new design system
- [x] 10.5 Visually verify dark mode rendering on all pages
