# AI Analysis Pipeline

> Feature: AI-powered CV analysis for candidates against job offers.

## Purpose

Enable authenticated users to trigger AI-based analysis of a candidate's CV against a job offer's requirements. Analysis runs asynchronously in a background queue, and results (matching score, recommendation, structured data) are stored and displayed.

## Requirements

### Requirement: AI analysis is triggered asynchronously and produces structured output

Authenticated users SHALL be able to trigger AI-powered CV analysis for a candidate against their job offer. The analysis SHALL run in a background queue. The AI SHALL be called using Laravel AI structured output with a typed DTO (`AnalysisData`). Results SHALL be validated and persisted in the `analyses` table with the structured JSON schema.

The structured analysis output SHALL contain:
- `extracted_skills`: array of all skills identified in the CV
- `years_of_experience`: integer with the candidate's total years of experience
- `education_level`: string describing highest education level (e.g., "Bachelor's", "Master's", "PhD")
- `languages`: array of strings listing languages the candidate speaks
- `matching_score`: integer between 0 and 100 representing fit for the job offer
- `strengths`: array of key strengths identified in the CV
- `weaknesses`: array of potential gaps or concerns
- `missing_skills`: array of required skills not found in CV
- `recommendation`: one of `convoquer`, `attente`, `rejeter`
- `justification`: string explaining the recommendation rationale

#### Scenario: Trigger analysis for a candidate
- **WHEN** an authenticated user submits or updates a candidate with CV text
- **WHEN** a user clicks "Run Analysis" on a candidate page
- **THEN** a `RunAnalysisJob` SHALL be dispatched to the queue
- **THEN** the user SHALL see a status message that analysis has been queued

#### Scenario: Analysis completes successfully with structured output
- **WHEN** the `RunAnalysisJob` processes and the LLM returns valid structured output via Laravel AI
- **THEN** the analysis SHALL be persisted with `structured_data`, `matching_score`, and `recommendation`
- **THEN** the `raw_ai_response` SHALL store the full LLM response
- **THEN** all fields in the new contract SHALL be present in `structured_data`

#### Scenario: Analysis fails validation
- **WHEN** the LLM returns invalid or incomplete structured output
- **THEN** the job SHALL store the raw response in `raw_ai_response`
- **THEN** the `structured_data` SHALL NOT be updated
- **THEN** the job SHALL log the error without crashing

#### Scenario: View analysis results
- **WHEN** an authenticated user views a candidate page with existing analysis
- **THEN** the page SHALL display the matching score, recommendation, and structured details including skills, experience, education, and languages
