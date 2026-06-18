## Why

The Job Offers CRUD has a controller, model, service, and route resource but is missing Form Requests for validation, a proper Policy for authorization (currently using a `Gate::define` fallback), and Blade views for the UI. These gaps prevent the feature from being fully functional and testable.

## What Changes

- Create `JobOfferPolicy` with `view`, `create`, `update`, `delete` abilities (replacing the inline `modify` gate)
- Create `StoreJobOfferRequest` and `UpdateJobOfferRequest` Form Requests with validation rules
- Create Blade views: `index`, `create`, `edit`, `show` with Tailwind UI
- Register the policy in `AppServiceProvider`
- No breaking changes — the existing controller, model, service, and routes remain

## Capabilities

### New Capabilities

- `job-offer-ui`: Blade views for listing, creating, editing, and viewing job offers

### Modified Capabilities

- `job-offer-crud`: Add authorization via Policy, add Form Request validation, add Blade views

## Impact

- **Policies**: New `JobOfferPolicy` class, remove `Gate::define('modify', ...)` from `AppServiceProvider`
- **Requests**: New `StoreJobOfferRequest` and `UpdateJobOfferRequest`
- **Views**: New `resources/views/job-offers/` directory with `index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`
- **Routes**: No changes needed (already uses `Route::resource`)
- **Controller**: Minor update to use Policy instead of inline gate
- **Tests**: New feature tests covering CRUD operations, authorization, and validation
