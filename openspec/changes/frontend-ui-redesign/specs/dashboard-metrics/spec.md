# Dashboard Metrics

## Purpose

Define the dashboard page that provides recruiters with an overview of their recruitment pipeline through KPIs, recent activity, and quick actions.

## ADDED Requirements

### Requirement: Dashboard displays KPI stat cards

The dashboard SHALL display a row of stat cards showing key recruitment metrics: total candidates, total job offers, total analyses performed, and average match score across all analyses.

#### Scenario: KPI cards render with correct values
- **WHEN** an authenticated user visits the dashboard
- **THEN** the page SHALL display a stat card for total candidates with the count
- **THEN** the page SHALL display a stat card for total job offers with the count
- **THEN** the page SHALL display a stat card for total analyses with the count
- **THEN** the page SHALL display a stat card for average match score (percentage)

#### Scenario: Empty state for KPI cards
- **WHEN** a new user has no candidates, job offers, or analyses
- **THEN** the stat cards SHALL display zero values without errors

### Requirement: Dashboard includes recent activity

The dashboard SHALL show a table or list of the 5 most recent analyses with candidate name, job offer title, matching score, and recommendation.

#### Scenario: Recent activity table renders
- **WHEN** analyses exist for the user's job offers
- **THEN** the dashboard SHALL display the 5 most recent analyses ordered by creation date descending
- **THEN** each row SHALL show the candidate name, job offer title, matching score (color-coded), and recommendation badge

#### Scenario: Empty state for recent activity
- **WHEN** no analyses exist
- **THEN** the dashboard SHALL display a meaningful empty state message

### Requirement: Dashboard includes quick-action cards

The dashboard SHALL display action cards that link to common tasks: creating a job offer, viewing candidates, and starting an AI analysis.

#### Scenario: Quick-action cards are visible and clickable
- **WHEN** the dashboard loads
- **THEN** the page SHALL display action cards with text descriptions and links
- **THEN** clicking a card SHALL navigate the user to the corresponding page
