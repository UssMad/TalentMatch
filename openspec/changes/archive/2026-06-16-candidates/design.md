## Context

The `Candidate` model is fully wired with fillable attributes, casts, and relationships (belongsTo JobOffer, hasMany Analysis/Conversation). The `candidates` table has all required columns from the `add-models-migration` change. However, there is no application layer: no controller, service, form requests, routes, or views.

## Goals / Non-Goals

**Goals:**
- Create `CandidateService` with CRUD business logic
- Create `CandidateController` with thin methods delegating to the service
- Create `StoreCandidateRequest` and `UpdateCandidateRequest` with validation rules
- Add nested resource routes under `job-offers/{jobOffer}/candidates`
- Create Blade views for index, create, show, and edit
- Add a "View Candidates" link to the job offer show page
- Add candidate count to job offer index cards

**Non-Goals:**
- CV file upload handling (cv_text is pasted text, cv_file_path stored as string)
- AI analysis integration (separate change)
- Pagination or advanced filtering
- Tests

## Decisions

- **Nested routes under job offers**: Candidates always belong to a job offer, so routes follow `/job-offers/{jobOffer}/candidates` pattern for clear ownership and URL structure.
- **Service layer mirrors JobOfferService**: Consistent pattern — `list(JobOffer)`, `create(array)`, `find(Candidate)`, `update(Candidate, array)`, `delete(Candidate)`.
- **`cv_text` as longText on the form**: Uses a textarea since CV text is the main data. The `cv_file_path` is kept for future file upload but not a focus of the create form.
- **Same authorization pattern**: Ownership check via the parent `JobOffer` — only the owner of the job offer can manage its candidates.

## Risks / Trade-offs

- **[Risk] Nested routes add URL complexity** → Acceptable for correct RESTful resource scoping. Laravel's implicit route model binding handles the nesting.
- **[Risk] Large CV text in forms** → Acceptable for MVP; consider file upload in a future change.
