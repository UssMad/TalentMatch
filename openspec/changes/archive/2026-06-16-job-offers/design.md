## Context

The `JobOffer` model and `job_offers` table are fully built with columns, casts, and relationships. However, there is no application layer above the model: no controller, service, form requests, routes, or views. Users can only manage job offers through direct database access or a future admin interface.

## Goals / Non-Goals

**Goals:**
- Create `JobOfferService` with all CRUD business logic
- Create `JobOfferController` with thin methods delegating to the service
- Create `StoreJobOfferRequest` and `UpdateJobOfferRequest` with validation rules
- Add resource routes for job offers under the `auth` middleware group
- Create Blade views for index, create, show, and edit
- Add `analyses()` hasMany relationship to the `JobOffer` model
- Add a "Job Offers" navigation link to the app layout

**Non-Goals:**
- API endpoints (REST or otherwise)
- Authorization beyond ownership checks (scoped to `$jobOffer->user_id === auth()->id()`)
- Pagination or advanced filtering (basic ordering only)
- Import/export functionality
- Tests (covered in a future testing change)

## Decisions

- **Service layer over repository pattern**: Following the project's architecture rule ("All business logic must be separated into Services"). A single `JobOfferService` handles all CRUD operations.
- **Form Requests for validation**: Using `StoreJobOfferRequest` and `UpdateJobOfferRequest` per the project rule ("Always use Form Requests for validation"). `required_skills` validated as an array of strings; `min_experience` validated as integer with `min:0`.
- **Authorization by route model binding**: `$jobOffer->user_id` check in the controller for edit/update/destroy. A policy is overkill for a single ownership check; a simple gate in the controller suffices for now.
- **Blade views with Breeze components**: Views use the existing Breeze component library (`x-input-label`, `x-text-input`, `x-primary-button`, etc.) for consistent styling.

## Risks / Trade-offs

- **[Risk] No pagination on index** → Acceptable for MVP; can be added later without breaking changes.
- **[Risk] Inline authorization instead of Policy** → If authorization logic grows, extract to a `JobOfferPolicy`. Refactoring is straightforward: add the policy, update the controller.
