## Purpose

Defines the UI requirements for the job offer management pages, including index, create, edit, and show views using the Breeze layout.

## Requirements

### Requirement: Job offer index page

The job offers index page SHALL list all job offers belonging to the authenticated user, ordered by most recent first. Each row SHALL show the title, minimum experience, and action buttons (view, edit, delete). The page SHALL extend the Breeze layout for consistent styling.

#### Scenario: Authenticated user visits index
- **WHEN** an authenticated user visits `/job-offers`
- **THEN** the page SHALL display a list of their job offers
- **THEN** an empty state message SHALL be shown if the user has no job offers
- **THEN** a "Create Job Offer" button SHALL be visible

### Requirement: Job offer create page

The create page SHALL display a form with fields for `title` (text input), `description` (textarea), `required_skills` (text inputs with add/remove), and `min_experience` (number input). Validation errors SHALL be displayed inline above the form.

#### Scenario: Create page renders form
- **WHEN** an authenticated user visits `/job-offers/create`
- **THEN** the form SHALL display with all required fields
- **THEN** submission SHALL POST to `/job-offers`

#### Scenario: Validation errors shown on invalid submission
- **WHEN** an authenticated user submits invalid data
- **THEN** the form SHALL re-display with validation error messages

### Requirement: Job offer edit page

The edit page SHALL display the same form as create, pre-filled with the existing job offer's data. Only the owner may access this page.

#### Scenario: Edit page renders form with existing data
- **WHEN** the owner visits `/job-offers/{jobOffer}/edit`
- **THEN** the form SHALL display with pre-filled values from the job offer

### Requirement: Job offer show page

The show page SHALL display the job offer's title, description, required skills list, and minimum experience in a read-only layout.

#### Scenario: Show page renders details
- **WHEN** the owner visits `/job-offers/{jobOffer}`
- **THEN** the page SHALL display title, description, required skills, and minimum experience
