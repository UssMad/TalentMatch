## Why

The current AI candidate analysis implementation uses raw LLM chat calls with manual JSON parsing, which is error-prone and lacks type safety. The JSON contract needs to align with actual recruitment workflows — extracting structured data like education level, years of experience, and languages — and recommendations must use the standardized French enum values (`convoquer`, `attente`, `rejeter`). Additionally, analysis should trigger automatically when a CV is submitted, not require a manual "Run Analysis" click.

## What Changes

- Replace raw `\AI::chat()->create()` with Laravel AI structured output for type-safe, validated AI responses
- Update the analysis JSON contract to include: `extracted_skills`, `years_of_experience`, `education_level`, `languages`, `matching_score` (0–100), `strengths`, `weaknesses`, `missing_skills`, `recommendation`, `justification`
- Change `Recommendation` enum values from English options to `convoquer`, `attente`, `rejeter`
- Auto-dispatch analysis job when a candidate CV is submitted (create/update)
- Update the `Analysis` model and DTO to match the new contract
- Update validation rules for the new contract
- Update existing tests to cover the new contract and auto-dispatch

## Capabilities

### New Capabilities

- `candidate-cv-submit`: Triggers analysis dispatch automatically when a candidate CV is created or updated

### Modified Capabilities

- `ai-analysis-pipeline`: Switch from raw LLM chat to Laravel AI structured output; update prompt to request the new JSON contract
- `analysis-schema`: Add new fields (`extracted_skills`, `years_of_experience`, `education_level`, `languages`, `justification`); change `recommendation` to use `convoquer`/`attente`/`rejeter` enum; remove `matched_skills`, `years_experience_fit`, `summary`, `recommendation_reasoning`

## Impact

- **Models**: `Analysis` model — update casts, fillable, and relationships
- **Enums**: `Recommendation` — replace cases with `convoquer`, `attente`, `rejeter`
- **DTOs**: `AnalysisResult` — update constructor and `toArray()` to match new contract
- **Services**: `AIAnalysisService` — use Laravel AI structured output; `AnalysisPrompt` — update prompt template; `AnalysisValidator` — update validation rules
- **Jobs**: `RunAnalysisJob` — no major changes needed
- **Controllers**: `CandidateController` — wire up auto-dispatch on store/update
- **Database**: Migration to update `analyses` table (add/drop columns, alter `recommendation` constraint)
- **Tests**: All tests referencing old contract or enum values must be updated
