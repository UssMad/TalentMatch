## Context

The `Analysis` model and `analyses` table are fully built with fillable attributes, casts, and relationships. The `laravel/ai` SDK is installed with OpenAI as the default provider. There is no pipeline to trigger or run AI analysis. No Jobs, Services, or controllers exist for analysis.

## Goals / Non-Goals

**Goals:**
- Create `AIAnalysisService` that orchestrates analysis: loads candidate CV + job requirements, calls LLM, validates response, persists result
- Create `RunAnalysisJob` that dispatches the analysis in a Redis queue
- Define a structured JSON schema for the AI output (skills matched, years fit score, recommendation reasoning, overall score)
- Create validators to sanitize and validate AI output before persisting (matching_score 0-100, recommendation must be valid enum)
- Create `AnalysisController` with a trigger action
- Add "Run Analysis" button on the candidate show page
- Display existing analysis results on the candidate show page

**Non-Goals:**
- Real-time analysis results (polling or SSE) — user refreshes page to see results
- Multiple AI provider selection (uses configured default)
- Batch analysis of all candidates for a job offer
- Tests

## Decisions

- **Job dispatch over sync call**: Following project rules ("All AI-heavy operations MUST run in background queues"). The controller dispatches `RunAnalysisJob` and returns immediately. User refreshes the page to see results.
- **Structured output via prompt instructions**: The LLM receives a carefully crafted system prompt asking for JSON output with a specific schema. The raw response is stored in `raw_ai_response` for debugging. The validated structured data goes into `structured_data`.
- **Prompt as a dedicated class**: The system prompt is defined in a `AnalysisPrompt` class for maintainability, rather than inline in the service.
- **DTO for structured data**: A simple `AnalysisResult` DTO (data transfer object) ensures type safety when passing the structured analysis around before persistence.
- **Validation pipeline**: After receiving the AI response, a validation step ensures: matching_score is int 0-100, recommendation is valid enum value, required fields are present. If validation fails, the job logs the error and stores the raw response for debugging without saving structured data.

## Risks / Trade-offs

- **[Risk] LLM may return invalid JSON or hallucinated scores** → Mitigation: validation pipeline catches invalid responses and stores in `raw_ai_response` without saving `structured_data`. Human review can re-trigger analysis.
- **[Risk] API key not configured** → Mitigation: the controller checks if analysis is possible before dispatching the job (e.g., cv_text is present).
- **[Risk] Long-running API calls** → Mitigation: the Job runs in the queue with a generous timeout. HTTP timeout is configurable.
