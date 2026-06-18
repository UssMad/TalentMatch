## Why

Candidate, Analysis, Conversation, and Message models and tables are currently stubs (only `id` + timestamps), blocking all AI-powered recruitment features. They must be fleshed out with proper columns, foreign keys, and Eloquent relationships before any feature work can proceed.

## What Changes

- Add columns to `candidates` table: `job_offer_id` FK, `name`, `email`, `phone`, `cv_text` (longText), `cv_file_path`
- Add columns to `analyses` table: `candidate_id` FK, `job_offer_id` FK, `structured_data` (JSON), `matching_score` (integer 0-100), `recommendation` (string enum), `raw_ai_response` (JSON)
- Add columns to `conversations` table: `candidate_id` FK, `user_id` FK, `title`, `context` (JSON)
- Add columns to `messages` table: `conversation_id` FK, `role` (string: user/assistant/system), `content` (longText), `tool_calls` (JSON nullable)
- Add `App\Models\Recommendation` enum with values: `Strongly Recommend`, `Recommend`, `Consider`, `Not Recommended`, `No Decision`
- Wire up Eloquent relationships across all models
- Add `$fillable`, `$casts`, `$hidden` properties to all models

## Capabilities

### New Capabilities
- `candidate-schema`: Database schema and Eloquent model for candidates with CV data and job offer association
- `analysis-schema`: Database schema and Eloquent model for AI analyses with structured JSON output, matching score, and recommendation enum
- `conversation-model`: Database schema and Eloquent model for conversations with user/candidate context
- `message-model`: Database schema and Eloquent model for messages with role, content, and tool call tracking

### Modified Capabilities
*(none)*

## Impact

- **Database**: New migration files adding columns to 4 existing tables
- **Models**: 4 model files updated with fillable, casts, relationships; new Recommendation enum created
- **Features**: All dependent features (CV analysis, conversation agent) now have a data foundation to build on
