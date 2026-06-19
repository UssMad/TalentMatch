# App Design System

## Purpose

Define the visual brand identity, design tokens, layout shell, and reusable component styling for the TalentMatch application. All views SHALL use these tokens and patterns for a consistent, modern appearance.

## ADDED Requirements

### Requirement: Brand color palette

The application SHALL define a custom brand color palette in `tailwind.config.js` under a `brand` color family with numbered shades from 50 to 950.

#### Scenario: Brand colors are available as Tailwind utilities
- **WHEN** any view uses a `brand-*` color utility (e.g., `bg-brand-600`, `text-brand-800`)
- **THEN** the color SHALL resolve to the defined palette
- **THEN** dark mode variants SHALL also resolve correctly

#### Scenario: Brand palette includes semantic accent colors
- **WHEN** the palette is defined
- **THEN** it SHALL include a primary brand color (professional blue/indigo)
- **THEN** it SHALL include semantic colors for success (green), warning (amber), danger (red), and info (sky)

### Requirement: UI shell layout

The authenticated layout shell SHALL consist of a top navigation bar with logo, nav links with icons, user dropdown, and a main content area with consistent max-width and padding.

#### Scenario: Layout renders consistently on all pages
- **WHEN** an authenticated user visits any application page
- **THEN** the page SHALL display the top navigation bar with the application logo, Dashboard and Job Offers links, and the user dropdown menu
- **THEN** the main content SHALL be wrapped in a container with `max-w-7xl mx-auto` and responsive padding

#### Scenario: Navigation links show active state
- **WHEN** a user is on a page matching a nav link
- **THEN** that nav link SHALL display a visual active indicator (e.g., underline or background highlight)
- **THEN** non-active links SHALL not show the indicator

#### Scenario: Mobile navigation is collapsible
- **WHEN** the viewport is below the `lg` breakpoint
- **THEN** the navigation SHALL collapse to a hamburger menu
- **THEN** toggling the hamburger SHALL show/hide the navigation links

### Requirement: Reusable component styling

All Blade X-components (buttons, inputs, labels, dropdowns, modals) SHALL use the brand color palette for their default styles.

#### Scenario: Buttons use brand colors
- **WHEN** a primary button is rendered
- **THEN** it SHALL use `bg-brand-600` (or appropriate brand shade) as its background
- **WHEN** a secondary button is rendered
- **THEN** it SHALL use a lighter brand shade or outlined style

#### Scenario: Form inputs have consistent focus ring
- **WHEN** a text input receives focus
- **THEN** the focus ring SHALL use the brand primary color (`ring-brand-500` / `border-brand-500`)

#### Scenario: Cards use consistent styling
- **WHEN** a card container is rendered
- **THEN** it SHALL have `bg-white dark:bg-gray-800`, a subtle shadow, and rounded corners

### Requirement: Typography

The application SHALL use the Figtree font family with consistent sizing and weight throughout the UI.

#### Scenario: Headings use consistent styles
- **WHEN** a page heading is rendered
- **THEN** it SHALL use `font-semibold text-xl sm:text-2xl text-gray-900 dark:text-gray-100`

#### Scenario: Body text uses readable size
- **WHEN** body or paragraph text is rendered
- **THEN** it SHALL use `text-sm sm:text-base text-gray-700 dark:text-gray-300`
