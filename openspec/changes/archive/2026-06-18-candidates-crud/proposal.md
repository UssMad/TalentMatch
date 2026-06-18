## Why

The Candidate CRUD feature (controller, service, form requests, routes, views) was implemented in a previous change, and its spec is already synced to main specs. However, there are no tests covering this feature — no policy tests, no controller/feature tests. This creates risk of regressions and makes it impossible to verify that authorization, validation, and CRUD flows work correctly.

## What Changes

- Create `CandidatePolicy` to centralize authorization (currently uses `Gate::authorize('modify', $jobOffer)` inline)
- Register `CandidatePolicy` in `AppServiceProvider`
- Update `CandidateController` to use policy authorization via `authorizeResource` or `Gate` methods
- Create `CandidatePolicyTest` with authorization tests for all abilities
- Create `CandidateControllerTest` with feature tests for all CRUD operations
- Add validation tests for store and update requests

## Capabilities

### New Capabilities
- `candidate-crud`: Full CRUD for candidates nested under job offers with service layer, validation, Blade views, and comprehensive tests

### Modified Capabilities
- *(none)*

## Impact

- **Policy**: New `CandidatePolicy` with viewAny, view, create, update, delete abilities
- **Controller**: Updated `CandidateController` to use policy authorization
- **Service Provider**: Register `CandidatePolicy` in `AppServiceProvider`
- **Tests**: New `CandidatePolicyTest` and `CandidateControllerTest`
