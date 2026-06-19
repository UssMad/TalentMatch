## Purpose

Defines the CRUD interface for managing candidates nested under job offers, including listing, viewing, creating, editing, and deleting candidates with ownership-based authorization via the parent job offer.

## Requirements

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

### Requirement: Authorization via CandidatePolicy

Access to candidate management SHALL be controlled by a `CandidatePolicy` with the following abilities:
- `viewAny`: all authenticated users may view candidates for their own job offers
- `view`: only the owner of the parent job offer may view a candidate
- `create`: only the owner of the parent job offer may create a candidate
- `update`: only the owner of the parent job offer may update a candidate
- `delete`: only the owner of the parent job offer may delete a candidate

#### Scenario: Owner can view candidates for their job offer
- **WHEN** the owner of a job offer accesses the candidates index
- **THEN** the page SHALL display the candidates

#### Scenario: Non-owner cannot view candidates
- **WHEN** a user who is not the owner of a job offer accesses its candidates
- **THEN** the system SHALL return a 403 Forbidden response

#### Scenario: Owner can create a candidate for their job offer
- **WHEN** the owner of a job offer submits the create candidate form with valid data
- **THEN** the candidate SHALL be created and persisted

#### Scenario: Non-owner cannot create a candidate
- **WHEN** a user who is not the owner submits the create candidate form
- **THEN** the system SHALL return a 403 Forbidden response

#### Scenario: Non-owner cannot edit a candidate
- **WHEN** a user who is not the owner attempts to edit a candidate
- **THEN** the system SHALL return a 403 Forbidden response

#### Scenario: Non-owner cannot delete a candidate
- **WHEN** a user who is not the owner attempts to delete a candidate
- **THEN** the system SHALL return a 403 Forbidden response

### Requirement: Form Request validation

Candidate data SHALL be validated using `StoreCandidateRequest` and `UpdateCandidateRequest` with the following rules:
- `name`: required, string, max:255
- `email`: required, email
- `phone`: nullable, string, max:20
- `cv_text`: required, string

#### Scenario: Create with valid data passes validation
- **WHEN** an authenticated user submits the create form with valid name, email, phone, and cv_text
- **THEN** the request SHALL pass validation

#### Scenario: Create with missing name fails validation
- **WHEN** a user submits the create form without a name
- **THEN** the request SHALL fail validation with an error on the name field

#### Scenario: Create with invalid email fails validation
- **WHEN** a user submits the create form with an invalid email
- **THEN** the request SHALL fail validation with an error on the email field

### Requirement: CRUD feature tests

The CandidateController SHALL be covered by feature tests verifying all CRUD operations, authorization, and validation.

#### Scenario: Index returns candidates for the job offer
- **WHEN** the owner visits the candidates index page
- **THEN** the page SHALL return 200 and display candidate names

#### Scenario: Store creates a candidate and redirects
- **WHEN** the owner submits valid candidate data to the store endpoint
- **THEN** the candidate SHALL be created in the database and the user SHALL be redirected to the index page

#### Scenario: Show displays candidate details
- **WHEN** the owner visits a candidate's show page
- **THEN** the page SHALL return 200 and display the candidate's name and CV text

#### Scenario: Update modifies a candidate
- **WHEN** the owner submits updated data to the update endpoint
- **THEN** the candidate SHALL be updated in the database

#### Scenario: Destroy deletes a candidate
- **WHEN** the owner submits a delete request
- **THEN** the candidate SHALL be removed from the database

#### Scenario: Unauthenticated user is redirected to login
- **WHEN** a guest visits any candidate page
- **THEN** the system SHALL redirect to the login page
