## Purpose

Defines the database schema and Eloquent model for candidates, including CV data storage and association with job offers.

## Requirements

### Requirement: Candidate stores CV data and belongs to a job offer

The `candidates` table SHALL store candidate details and CV content. Every candidate MUST belong to exactly one job offer via a foreign key. Deleting a job offer MUST cascade-delete its candidates.

#### Scenario: Create a candidate for a job offer
- **WHEN** a new candidate is created with `name`, `email`, `phone`, `cv_text`, and a valid `job_offer_id`
- **THEN** the candidate record SHALL be persisted in the `candidates` table with all provided fields and a foreign key referencing the `job_offers` table

#### Scenario: Delete job offer cascades to candidates
- **WHEN** a job offer is deleted
- **THEN** all associated candidate records SHALL be deleted automatically

#### Scenario: Candidate Eloquent model has fillable attributes
- **WHEN** a Candidate model is created via mass-assignment
- **THEN** the model SHALL accept `name`, `email`, `phone`, `cv_text`, `cv_file_path`, and `job_offer_id`

#### Scenario: Candidate belongs to job offer
- **WHEN** accessing `$candidate->jobOffer`
- **THEN** the relationship SHALL return the parent `JobOffer` model

#### Scenario: Candidate has many analyses
- **WHEN** accessing `$candidate->analyses`
- **THEN** the relationship SHALL return a collection of associated `Analysis` models

#### Scenario: Candidate has many conversations
- **WHEN** accessing `$candidate->conversations`
- **THEN** the relationship SHALL return a collection of associated `Conversation` models
