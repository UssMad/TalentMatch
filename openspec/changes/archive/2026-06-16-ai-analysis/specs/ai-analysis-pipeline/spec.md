## ADDED Requirements

### Requirement: AI analysis is triggered asynchronously and produces structured output

Authenticated users SHALL be able to trigger AI-powered CV analysis for a candidate against their job offer. The analysis SHALL run in a background queue. Results SHALL be validated and persisted in the `analyses` table with a structured JSON schema.

The structured analysis output SHALL contain:
- `matched_skills`: array of skill names that match between CV and job requirements
- `missing_skills`: array of required skills not found in CV
- `years_experience_fit`: boolean indicating if candidate's experience meets minimum
- `strengths`: array of key strengths identified in the CV
- `weaknesses`: array of potential gaps or concerns
- `summary`: string with a brief textual summary
- `recommendation_reasoning`: string explaining the recommendation rationale

#### Scenario: Trigger analysis for a candidate
- **WHEN** an authenticated user clicks "Run Analysis" on a candidate page
- **THEN** a `RunAnalysisJob` SHALL be dispatched to the queue
- **THEN** the user SHALL see a status message that analysis has been queued

#### Scenario: Analysis completes successfully
- **WHEN** the `RunAnalysisJob` processes and the LLM returns valid structured JSON
- **THEN** the analysis SHALL be persisted with `structured_data`, `matching_score`, and `recommendation`
- **THEN** the `raw_ai_response` SHALL store the full LLM response

#### Scenario: Analysis fails validation
- **WHEN** the LLM returns invalid or incomplete JSON
- **THEN** the job SHALL store the raw response in `raw_ai_response`
- **THEN** the `structured_data` SHALL NOT be updated
- **THEN** the job SHALL log the error without crashing

#### Scenario: View analysis results
- **WHEN** an authenticated user views a candidate page with existing analysis
- **THEN** the page SHALL display the matching score, recommendation, and structured details
