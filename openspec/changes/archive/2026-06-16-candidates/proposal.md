## Why

The Candidate model has fillable attributes and relationships but there is no UI or API layer to create, view, or manage candidates. Users currently have no way to add candidates to a job offer or upload CV text. This blocks the entire AI-powered CV analysis pipeline since candidates are the input source.

## What Changes

- Create `CandidateService` with business logic for CRUD operations
- Create `CandidateController` with thin methods (index, create, store, show, edit, update, destroy)
- Nest candidate routes under job offers (e.g., `/job-offers/{jobOffer}/candidates`)
- Create `StoreCandidateRequest` and `UpdateCandidateRequest` form requests with validation
- Create Blade views: index (list candidates for a job offer), create, show, edit
- Add "View Candidates" button to the job offer show page
- Add candidate count indicator on job offer index cards

## Capabilities

### New Capabilities
- `candidate-crud`: Full CRUD for candidates nested under job offers with service layer, validation, and Blade views

### Modified Capabilities
*(none)*

## Impact

- **Controllers**: New `CandidateController`
- **Services**: New `CandidateService`
- **Requests**: New `StoreCandidateRequest`, `UpdateCandidateRequest`
- **Routes**: New nested resource routes in `web.php`
- **Views**: New views under `resources/views/candidates/`
- **Job offer views**: Updated show and index views with candidate links and counts
