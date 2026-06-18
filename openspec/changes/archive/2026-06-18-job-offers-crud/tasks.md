## 1. Policy & Authorization

- [ ] 1.1 Create `JobOfferPolicy` with `viewAny`, `view`, `create`, `update`, `delete` abilities
- [ ] 1.2 Register `JobOfferPolicy` in `AppServiceProvider` and remove the inline `Gate::define('modify', ...)`
- [ ] 1.3 Update `JobOfferController` to use `JobOfferPolicy` (via `authorizeResource` or `Gate::authorize`) and remove the private `authorizeOwner` method
- [ ] 1.4 Add `modify` ability to `JobOfferPolicy` for backward compatibility with `CandidateController` and `AnalysisController`

## 2. Form Requests

- [ ] 2.1 Create `StoreJobOfferRequest` with validation rules for title, description, required_skills, min_experience
- [ ] 2.2 Create `UpdateJobOfferRequest` with validation rules for title, description, required_skills, min_experience

## 3. Blade Views

- [ ] 3.1 Create `resources/views/job-offers/index.blade.php` with table listing, empty state, and create button
- [ ] 3.2 Create `resources/views/job-offers/create.blade.php` with form for all fields
- [ ] 3.3 Create `resources/views/job-offers/edit.blade.php` with pre-filled form
- [ ] 3.4 Create `resources/views/job-offers/show.blade.php` with read-only details
- [ ] 3.5 Add navigation link to job offers index in the Breeze layout

## 4. Tests

- [ ] 4.1 Create `JobOfferPolicyTest` with authorization tests for all abilities
- [ ] 4.2 Create `JobOfferControllerTest` with feature tests for all CRUD operations
- [ ] 4.3 Add validation tests for store and update requests
- [ ] 4.4 Run full test suite and fix any regressions

## 5. Final Quality

- [ ] 5.1 Run `vendor/bin/pint` to format all modified PHP files
- [ ] 5.2 Run `php artisan test --compact` to verify all tests pass
