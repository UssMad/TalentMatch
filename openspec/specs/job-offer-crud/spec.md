## Purpose

Defines the CRUD interface for managing job offers, including listing, viewing, creating, editing, and deleting job offers with ownership-based authorization.

## Requirements

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

### Requirement: Authorization via Policy

Access to job offer management SHALL be controlled by a `JobOfferPolicy` with the following abilities:
- `viewAny`: all authenticated users may list their own job offers
- `view`: only the owner may view a job offer
- `create`: all authenticated users may create job offers
- `update`: only the owner may update a job offer
- `delete`: only the owner may delete a job offer

#### Scenario: Owner can view their job offer
- **WHEN** the owner of a job offer accesses the show page
- **THEN** the page SHALL be displayed successfully

#### Scenario: Non-owner cannot view a job offer
- **WHEN** a user who is not the owner accesses a job offer's show page
- **THEN** the system SHALL return a 403 Forbidden response

#### Scenario: Non-owner cannot edit a job offer
- **WHEN** a user who is not the owner attempts to edit a job offer
- **THEN** the system SHALL return a 403 Forbidden response

#### Scenario: Non-owner cannot delete a job offer
- **WHEN** a user who is not the owner attempts to delete a job offer
- **THEN** the system SHALL return a 403 Forbidden response

### Requirement: Form Request validation

Job offer data SHALL be validated using Form Request classes before storage or update. The `StoreJobOfferRequest` and `UpdateJobOfferRequest` SHALL validate:
- `title`: required, string, max:255
- `description`: required, string
- `required_skills`: required, array, each item a string
- `min_experience`: required, integer, min:0

#### Scenario: Create with valid data passes validation
- **WHEN** an authenticated user submits the create form with valid `title`, `description`, `required_skills` array, and `min_experience`
- **THEN** the request SHALL pass validation

#### Scenario: Create with missing title fails validation
- **WHEN** an authenticated user submits the create form without a title
- **THEN** the request SHALL fail validation with an error on the `title` field

#### Scenario: Create with non-array required_skills fails validation
- **WHEN** an authenticated user submits the create form with `required_skills` as a string instead of an array
- **THEN** the request SHALL fail validation with an error on the `required_skills` field

#### Scenario: Create with negative min_experience fails validation
- **WHEN** an authenticated user submits the create form with `min_experience` set to -1
- **THEN** the request SHALL fail validation with an error on the `min_experience` field
