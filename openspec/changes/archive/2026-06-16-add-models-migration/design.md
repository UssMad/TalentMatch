## Context

The `candidates`, `analyses`, `conversations`, and `messages` tables exist as stubs (only `id` + timestamps) from initial scaffolding. Their Eloquent models are empty shells. The `JobOffer` model is the only fully wired model with fillable attributes, casts, and relationships. Before any AI-powered features can be built (CV analysis, conversational agent), the data layer must be complete.

## Goals / Non-Goals

**Goals:**
- Add all required columns to existing stub tables via new migration files (not modifying existing migrations)
- Define proper foreign key relationships with cascade deletes where appropriate
- Wire up Eloquent models with `$fillable`, `$casts`, relationships, and helper methods
- Create a `Recommendation` backed enum for the analysis recommendation field
- Ensure schema follows the constraints defined in `openspec/config.yaml` feature rules

**Non-Goals:**
- Creating controllers, services, or feature logic (those come in later changes)
- Seeding data or building factories
- Modifying the `job_offers` table or `User` model
- Adding indexes beyond foreign keys (optimization deferred)

## Decisions

- **New migrations over editing existing stubs**: The stub migrations already ran in production-like environments. Adding columns via new `Schema::table` migrations is safer and follows Laravel convention. Migration files will be timestamped after the existing stubs.
- **Backed enum for recommendation**: Using PHP 8.1+ backed enums (`Recommendation: string`) ensures type safety and matches the `openspec/config.yaml` requirement for typed enums. Values: `Strongly Recommend`, `Recommend`, `Consider`, `Not Recommended`, `No Decision`.
- **JSON columns for structured data**: `analyses.structured_data` and `analyses.raw_ai_response` use MySQL JSON columns for schema flexibility. The `structured_data` column holds the validated AI output; `raw_ai_response` stores the pre-validation payload for debugging.
- **cascadeOnDelete for all FKs**: Deleting a job offer cascades to candidates and analyses; deleting a conversation cascades to messages. This keeps referential integrity without manual cleanup.
- **`cv_text` as longText**: Following project rules (`candidates` feature: "CV text must be stored as longText"). CVs can be multi-page documents exceeding varchar limits.

## Risks / Trade-offs

- **[Risk] JSON columns lack schema enforcement at DB level** → Mitigation: Validate all writes in Services before persisting; use Laravel's `$casts` for type hinting at the model layer.
- **[Risk] Altering production tables with existing data** → Mitigation: New columns that aren't nullable must have defaults defined. For the MVP, all new columns that should be NOT NULL will have reasonable defaults or be nullable initially.
- **[Risk] Running multiple migrations can delay deployment** → Acceptable for an MVP; these are additive-only changes with no rollback complexity beyond `migrate:rollback`.
