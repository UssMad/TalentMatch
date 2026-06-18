## Why

The JobOffer model and migration exist but there is no CRUD layer — no controller, service, form requests, routes, or views. Users cannot create, view, edit, or delete job offers through the UI. This blocks the entire recruitment workflow since candidates and analyses depend on job offers.

## What Changes

- Create `JobOfferService` with business logic for CRUD operations
- Create `JobOfferController` with thin controller methods (index, create, store, show, edit, update, destroy)
- Create `StoreJobOfferRequest` and `UpdateJobOfferRequest` form requests with validation
- Add job offer resource routes (authenticated)
- Create Blade views: index (list), create, show, edit
- Add `analyses()` relationship to `JobOffer` model
- Add job offers navigation link to the app layout
- Destroy must check authorization (only owner can modify)

## Capabilities

### New Capabilities
- `job-offer-crud`: Full CRUD for job offers with service layer, validation, authorization, and Blade views

### Modified Capabilities
*(none)*

## Impact

- **Controllers**: New `JobOfferController`
- **Services**: New `JobOfferService`
- **Requests**: New `StoreJobOfferRequest`, `UpdateJobOfferRequest`
- **Routes**: New resource routes in `web.php`
- **Views**: New views under `resources/views/job-offers/`
- **Models**: Added `analyses()` relationship to `JobOffer`
- **Layout**: Navigation link added to app layout
