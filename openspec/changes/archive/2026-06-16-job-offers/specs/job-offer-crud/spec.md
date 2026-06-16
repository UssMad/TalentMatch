## ADDED Requirements

### Requirement: Users can list, view, create, edit, and delete job offers

Authenticated users SHALL be able to manage their own job offers through a web UI. Each job offer SHALL belong to exactly one user. Only the owner SHALL be able to edit or delete a job offer.

#### Scenario: List job offers
- **WHEN** an authenticated user visits the job offers index page
- **THEN** the page SHALL display all job offers belonging to that user, ordered by most recent first

#### Scenario: View a single job offer
- **WHEN** an authenticated user visits a job offer show page
- **THEN** the page SHALL display the job offer's title, description, required skills, and minimum experience

#### Scenario: Create a job offer with valid data
- **WHEN** an authenticated user submits the create form with `title`, `description`, `required_skills` array, and `min_experience`
- **THEN** a new job offer SHALL be created and persisted, associated with the authenticated user

#### Scenario: Create a job offer with invalid data
- **WHEN** an authenticated user submits the create form with missing or invalid fields
- **THEN** the form SHALL re-display with validation errors

#### Scenario: Edit own job offer
- **WHEN** the owner of a job offer submits the edit form with updated fields
- **THEN** the job offer SHALL be updated in the database

#### Scenario: Edit another user's job offer returns 403
- **WHEN** a user who is not the owner attempts to edit a job offer
- **THEN** the system SHALL return a 403 Forbidden response

#### Scenario: Delete own job offer
- **WHEN** the owner of a job offer clicks delete
- **THEN** the job offer SHALL be removed from the database

#### Scenario: Delete another user's job offer returns 403
- **WHEN** a user who is not the owner attempts to delete a job offer
- **THEN** the system SHALL return a 403 Forbidden response
