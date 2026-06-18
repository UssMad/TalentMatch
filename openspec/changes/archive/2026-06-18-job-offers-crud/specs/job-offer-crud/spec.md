## ADDED Requirements

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
