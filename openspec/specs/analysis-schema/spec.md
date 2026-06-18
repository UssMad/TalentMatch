## Purpose

Defines the database schema and Eloquent model for AI-powered CV analysis results, including structured JSON output, matching score, and recommendation enum.

## Requirements

### Requirement: Analysis stores structured AI output with matching score and recommendation (updated contract)

The `analyses` table SHALL persist the structured output of AI-powered CV analysis. Each analysis MUST be associated with one candidate and one job offer. The matching score SHALL be an integer between 0 and 100. The recommendation SHALL be a backed enum with values: `convoquer`, `attente`, `rejeter`.

The `structured_data` JSON SHALL contain the following fields:
- `extracted_skills` (array of strings)
- `years_of_experience` (integer)
- `education_level` (string)
- `languages` (array of strings)
- `strengths` (array of strings)
- `weaknesses` (array of strings)
- `missing_skills` (array of strings)
- `justification` (string)

#### Scenario: Create an analysis for a candidate and job offer (updated)
- **WHEN** an analysis is created with valid `candidate_id`, `job_offer_id`, `structured_data` JSON (with new contract fields), `matching_score` (0-100), `recommendation` enum value (`convoquer`, `attente`, or `rejeter`), and `raw_ai_response` JSON
- **THEN** the analysis record SHALL be persisted in the `analyses` table with all provided fields and foreign keys referencing `candidates` and `job_offers`

#### Scenario: Analysis belongs to candidate
- **WHEN** accessing `$analysis->candidate`
- **THEN** the relationship SHALL return the associated `Candidate` model

#### Scenario: Analysis belongs to job offer
- **WHEN** accessing `$analysis->jobOffer`
- **THEN** the relationship SHALL return the associated `JobOffer` model

#### Scenario: Recommendation uses backed enum with French values
- **WHEN** setting the `recommendation` attribute
- **THEN** the value SHALL be an instance of `App\Enums\Recommendation` with valid values: `convoquer`, `attente`, `rejeter`

#### Scenario: Matching score is validated as integer 0-100
- **WHEN** a matching score outside the 0-100 range is provided
- **THEN** the model SHALL enforce validation at the service layer (not database constraint)

#### Scenario: Delete candidate cascades analyses
- **WHEN** a candidate record is deleted
- **THEN** all associated analysis records SHALL be deleted automatically

### Requirement: Structured data validation for new contract

The system MUST validate the new `structured_data` fields before persisting:
- `extracted_skills` MUST be a non-empty array of strings
- `years_of_experience` MUST be a non-negative integer
- `education_level` MUST be a non-empty string
- `languages` MUST be an array of strings
- `justification` MUST be a non-empty string

#### Scenario: Invalid structured data is rejected
- **WHEN** AI returns structured output with missing or invalid fields per the new contract
- **THEN** the analysis SHALL NOT be persisted with invalid `structured_data`
- **THEN** the error SHALL be logged and the raw response saved
