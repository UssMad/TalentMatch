## 1. Policy & Authorization

- [x] 1.1 Create `CandidatePolicy` with `viewAny`, `view`, `create`, `update`, `delete` abilities checking ownership via parent job offer
- [x] 1.2 Register `CandidatePolicy` in `AppServiceProvider`
- [x] 1.3 Update `CandidateController` to use `CandidatePolicy` instead of `Gate::authorize('modify', $jobOffer)`

## 2. Tests

- [x] 2.1 Create `CandidatePolicyTest` with authorization tests for all 5 abilities (owner vs non-owner)
- [x] 2.2 Create `CandidateControllerTest` with feature tests for all CRUD operations (index, create, store, show, edit, update, destroy)
- [x] 2.3 Add validation tests for store and update requests (missing name, invalid email, etc.)

## 3. Final Quality

- [x] 3.1 Run `vendor/bin/pint` to format all modified PHP files
- [x] 3.2 Run `php artisan test --compact` to verify all tests pass
