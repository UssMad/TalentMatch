## ADDED Requirements

### Requirement: Users can list, view, create, edit, and delete candidates for a job offer

Authenticated users SHALL be able to manage candidates associated with their job offers. Candidates SHALL always belong to a job offer. Only the owner of the parent job offer SHALL be able to manage its candidates.

#### Scenario: List candidates for a job offer
- **WHEN** an authenticated user visits the candidates index page for a job offer
- **THEN** the page SHALL display all candidates belonging to that job offer

#### Scenario: View a single candidate
- **WHEN** an authenticated user visits a candidate show page
- **THEN** the page SHALL display the candidate's name, email, phone, and CV text

#### Scenario: Create a candidate with valid data
- **WHEN** an authenticated user submits the create form with `name`, `email`, `phone`, `cv_text`, and a valid `job_offer_id`
- **THEN** a new candidate SHALL be created and persisted, associated with the job offer

#### Scenario: Create a candidate with invalid data
- **WHEN** an authenticated user submits the create form with missing or invalid fields
- **THEN** the form SHALL re-display with validation errors

#### Scenario: Edit a candidate
- **WHEN** the owner of the parent job offer submits the edit form with updated fields
- **THEN** the candidate SHALL be updated in the database

#### Scenario: Delete a candidate
- **WHEN** the owner of the parent job offer clicks delete
- **THEN** the candidate SHALL be removed from the database

#### Scenario: Non-owner cannot manage candidates
- **WHEN** a user who is not the owner of the parent job offer attempts to access candidates
- **THEN** the system SHALL return a 403 Forbidden response
