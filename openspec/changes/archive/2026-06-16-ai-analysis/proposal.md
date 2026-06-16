## Why

The Analysis model and `analyses` table are fully built, but there is no AI pipeline to actually run CV analysis. Users cannot trigger analysis, the AI service is not wired up, and there are no queue jobs to process analysis asynchronously. This blocks the core recruitment feature.

## What Changes

- Create `AIAnalysisService` to orchestrate: fetch candidate CV + job requirements, call LLM, validate structured output, persist to `analyses` table
- Create `RunAnalysisJob` to run analysis in a Redis queue (non-blocking HTTP request)
- Create a DTO/value object for the structured analysis result schema (skills matched, years fit, recommendation reasoning, etc.)
- Create validation logic to validate and sanitize AI output before persisting
- Create `AnalysisController` with a trigger action
- Add "Run Analysis" button to candidate show page
- Add analysis results display components
- Add a route to trigger analysis

## Capabilities

### New Capabilities
- `ai-analysis-pipeline`: Background job + service to run structured CV analysis against job offers using LLM, with validated output persistence

### Modified Capabilities
*(none)*

## Impact

- **Services**: New `AIAnalysisService`
- **Jobs**: New `RunAnalysisJob`
- **Controllers**: New `AnalysisController`
- **Routes**: New route to trigger analysis
- **Views**: Updated candidate view with analysis trigger and results
- **Data**: AI analysis results persisted via the existing Analysis model
