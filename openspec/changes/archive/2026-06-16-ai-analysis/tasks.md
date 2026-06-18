## 1. DTO / Value Object

- [x] 1.1 Create `AnalysisResult` DTO with typed properties: matchedSkills, missingSkills, yearsExperienceFit, strengths, weaknesses, summary, recommendationReasoning

## 2. Prompt

- [x] 2.1 Create `AnalysisPrompt` class that generates the system prompt instructing the LLM to return structured JSON in the expected schema

## 3. Service

- [x] 3.1 Create `AIAnalysisService` with `analyze(Candidate, JobOffer)` method: loads CV + requirements, builds prompt, calls LLM, validates response, returns AnalysisResult

## 4. Validation

- [x] 4.1 Create `AnalysisValidator` to validate AI output: matching_score is int 0-100, recommendation is valid enum, required fields present, structured_data keys match schema

## 5. Job

- [x] 5.1 Create `RunAnalysisJob` that receives candidate_id and job_offer_id, calls AIAnalysisService, persists the validated result to the analyses table

## 6. Controller

- [x] 6.1 Create `AnalysisController` with a `trigger` action that dispatches `RunAnalysisJob` and redirects back with status message

## 7. Routes

- [x] 7.1 Add trigger route: `POST /job-offers/{jobOffer}/candidates/{candidate}/analyze` inside auth middleware

## 8. Views

- [x] 8.1 Add "Run Analysis" button to `candidates/show.blade.php`
- [x] 8.2 Display existing analysis results (matching score, recommendation, structured data) on `candidates/show.blade.php`
