## ADDED Requirements

### Requirement: Analysis automatically dispatched on CV submission

When a candidate record is created or updated with CV text, the system SHALL automatically dispatch a `RunAnalysisJob` to analyze the CV against the candidate's associated job offer. This eliminates the need for a manual "Run Analysis" action for every new submission.

#### Scenario: CV submitted on candidate creation
- **WHEN** a new candidate is created with non-empty `cv_text`
- **THEN** a `RunAnalysisJob` SHALL be dispatched with the candidate's ID and their associated `job_offer_id`
- **THEN** the candidate SHALL be persisted before the job is dispatched

#### Scenario: CV updated on existing candidate
- **WHEN** an existing candidate's `cv_text` field is updated to a new non-empty value
- **THEN** a `RunAnalysisJob` SHALL be dispatched for the updated candidate
- **THEN** the job SHALL NOT be dispatched if only non-CV fields (e.g., name, email) are changed

#### Scenario: CV submission without job offer
- **WHEN** a candidate is created with `cv_text` but without an associated `job_offer_id`
- **THEN** no analysis job SHALL be dispatched
- **THEN** the candidate SHALL be created normally

#### Scenario: Analysis failure on auto-dispatch
- **WHEN** a `RunAnalysisJob` dispatched via auto-submit fails
- **THEN** the failure SHALL be logged
- **THEN** the candidate record SHALL remain intact with no analysis data
- **THEN** the user SHALL be able to manually re-trigger analysis
