## Context

The `JobOfferController` was scaffolded with all CRUD methods but relies on a `Gate::define('modify', ...)` fallback in `AppServiceProvider` instead of a proper Policy. Form Request classes (`StoreJobOfferRequest`, `UpdateJobOfferRequest`) are imported by the controller but don't exist yet. No Blade views exist — accessing any job-offers route will throw an error. The `JobOffer` model, `JobOfferService`, and migration are fully functional.

## Goals / Non-Goals

**Goals:**

- Create `JobOfferPolicy` with standard CRUD abilities (`viewAny`, `view`, `create`, `update`, `delete`)
- Remove the inline `Gate::define('modify', ...)` from `AppServiceProvider`
- Create `StoreJobOfferRequest` with validation rules for title, description, required_skills, min_experience
- Create `UpdateJobOfferRequest` with the same validation rules
- Create Blade views for index, create, edit, show with Tailwind UI consistent with Breeze styling
- Add feature tests covering all CRUD operations, authorization checks, and validation errors

**Non-Goals:**

- No changes to the `JobOffer` model or migration
- No changes to `JobOfferService` (already handles CRUD correctly)
- No changes to routes (already uses resource controller)
- No new API endpoints

## Decisions

**Decision: Use Policy class instead of Gate::define**

- *Alternative considered*: Keep the inline gate in `AppServiceProvider` — rejected because it doesn't scale, lacks automatic model-based authorization, and can't be tested independently.
- *Rationale*: Policies are the Laravel convention for model authorization. They integrate with `Gate::authorize()`, `$this->authorize()`, and Blade `@can` directives. The `JobOfferPolicy` will follow the standard 5-method pattern.

**Decision: Separate Form Requests for store and update**

- *Alternative considered*: Single request class — rejected because store and update may diverge in rules later (e.g., unique title on create but not on update).
- *Rationale*: Starting with identical rules is fine; separating them now avoids a breaking change later. Both validate: `title` (required, string, max:255), `description` (required, string), `required_skills` (required, array), `min_experience` (required, integer, min:0).

**Decision: Tailwind views matching Breeze layout**

- *Alternative considered*: Minimal unstyled views — rejected because they must integrate with the existing Breeze-styled layout.
- *Rationale*: The views will extend `layouts.app`, use Tailwind forms, and follow the same patterns as other Breeze views for consistency.

## Risks / Trade-offs

- [Removing `Gate::define('modify', ...)` breaks existing Candidate/ Analysis controllers] → Those controllers reference `Gate::authorize('modify', $jobOffer)`. The `modify` ability must be defined in the Policy to avoid breaking other features.
- [Policy won't auto-resolve if naming convention isn't followed] → The `JobOffer` model and `JobOfferPolicy` naming follows Laravel convention, so auto-discovery works. Explicit registration in `AppServiceProvider` as a safety net is recommended.
