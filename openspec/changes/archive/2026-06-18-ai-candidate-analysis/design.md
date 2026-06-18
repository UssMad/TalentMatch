## Context

The current AI analysis pipeline uses a raw `\AI::chat()->create()` call with manual JSON parsing via regex and `json_decode`. This approach lacks type safety, requires custom validation, and is fragile when the LLM returns unexpected formatting. The analysis contract (`matched_skills`, `years_experience_fit`, `summary`, `recommendation_reasoning`) doesn't align with the structured data recruiters actually need. The `Recommendation` enum uses English values (`Strongly Recommend`, `Recommend`, etc.) instead of the standardized French values (`convoquer`, `attente`, `rejeter`). Analysis is only triggered manually, not on CV submission.

The codebase already has: `Analysis` model with `candidate_id`, `job_offer_id`, `structured_data`, `matching_score`, `recommendation`, `raw_ai_response`; `RunAnalysisJob` that dispatches to queue; `AIAnalysisService` that calls LLM and parses response; `AnalysisResult` DTO; `AnalysisValidator` for field validation; `AnalysisPrompt` for prompt construction.

## Goals / Non-Goals

**Goals:**

- Replace raw LLM chat with Laravel AI structured output for type-safe AI responses
- Update the analysis JSON contract to: `extracted_skills`, `years_of_experience`, `education_level`, `languages`, `matching_score`, `strengths`, `weaknesses`, `missing_skills`, `recommendation`, `justification`
- Change `Recommendation` enum to `convoquer`, `attente`, `rejeter`
- Auto-dispatch `RunAnalysisJob` when a candidate CV is created or updated
- Update all affected models, DTOs, services, and validators
- Handle invalid AI responses gracefully with proper fallback

**Non-Goals:**

- No changes to the conversational agent (Layer 2)
- No changes to candidate CRUD beyond auto-dispatch wiring
- No changes to the job offer CRUD
- No changes to the database queue configuration

## Decisions

**Decision: Use Laravel AI structured output instead of raw chat**

- *Alternative considered*: Continue with raw `\AI::chat()->create()` + manual JSON parsing — rejected because it requires fragile regex parsing, custom validation, and doesn't leverage the SDK's built-in type safety.
- *Rationale*: Laravel AI structured output accepts a PHP class/struct and returns a typed result. This eliminates manual JSON parsing, provides compile-time validation, and integrates with the SDK's retry and error handling.

**Decision: Define a dedicated `AnalysisData` DTO for structured output**

- *Alternative considered*: Reuse `AnalysisResult` DTO directly — rejected because the new contract has significantly different fields, and mixing concerns is cleaner.
- *Rationale*: The DTO used by the AI SDK (`AnalysisData`) mirrors the new JSON contract exactly. A separate mapper converts `AnalysisData` to the existing `AnalysisResult` (or replaces it). This keeps the SDK boundary clean.

**Decision: Replace Recommendation enum values in-place**

- *Alternative considered*: Create a new enum alongside the old one — rejected to avoid confusion and dead code.
- *Rationale*: The three new values (`convoquer`, `attente`, `rejeter`) are the single source of truth. All references will be updated atomically.

**Decision: Auto-dispatch via Candidate model events (creating/updating)**

- *Alternative considered*: Dispatch from the controller store/update methods — rejected because it violates thin controller principle.
- *Alternative considered*: Use a dedicated observer class — viable but adds an extra file for one event type.
- *Rationale*: Using Eloquent model events (`creating`, `updating`) on `Candidate` keeps dispatch logic co-located with the model and avoids adding observer boilerplate. The event checks if `cv_text` is present and dispatches the job.

## Risks / Trade-offs

- [Breaking change to enum values] → All existing `analyses` records with old enum values will become invalid. A migration must be provided to update or archive old records.
- [New contract means existing analysis data won't have new fields] → The migration can drop unnecessary columns and add new nullable ones. Old data in `structured_data` may need to be re-analyzed or treated as legacy.
- [Auto-dispatch on every save could trigger unnecessary jobs] → Mitigated by checking `cv_text` presence and potentially using `wasChanged('cv_text')` to avoid re-triggering on non-CV updates.
