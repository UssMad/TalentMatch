## Context

The Candidate CRUD feature is fully implemented — model, controller, service, form requests, routes, and Blade views all exist. Authorization uses `Gate::authorize('modify', $jobOffer)` inline in each controller method, which delegates to `JobOfferPolicy::modify()`. No tests exist for the candidate feature.

## Goals / Non-Goals

**Goals:**
- Create `CandidatePolicy` with standard abilities (viewAny, view, create, update, delete) checking ownership via the parent job offer
- Register `CandidatePolicy` in `AppServiceProvider`
- Update `CandidateController` to use `Gate::authorize()` with the new policy methods
- Create `CandidatePolicyTest` covering all abilities (owner vs non-owner)
- Create `CandidateControllerTest` covering all CRUD operations (index, create, store, show, edit, update, destroy) with auth and validation tests

**Non-Goals:**
- No changes to existing Blade views, routes, model, or service logic
- No changes to the auto-analysis dispatch on candidate create/update

## Decisions

- **New CandidatePolicy instead of reusing JobOfferPolicy**: Using the JobOfferPolicy's `modify` ability for candidate authorization couples the two features. A dedicated `CandidatePolicy` provides cleaner separation and follows the standard Laravel pattern (one policy per model).
- **Same ownership check pattern**: The policy checks that the candidate's job offer belongs to the authenticated user, consistent with how `JobOfferPolicy::modify()` works today.
- **authorizeResource not used**: Since candidates are nested under job offers, route model binding passes both `JobOffer` and `Candidate`. `authorizeResource` doesn't map well to this pattern, so explicit `Gate::authorize()` calls in the controller are kept — but updated to use `CandidatePolicy` methods instead of `JobOfferPolicy::modify()`.
- **Pest test structure follows job-offers-crud**: Policy tests as `TestCase`-based feature tests (use factories), controller tests with `actingAs` and Route facade.

## Risks / Trade-offs

- **[Risk] Existing Gate::authorize('modify') usage** → Mitigation: keep `modify` on `JobOfferPolicy` for backward compatibility with `AnalysisController`; only `CandidateController` moves to the new policy.
- **[Risk] Nested route binding complexity in tests** → Acceptable; Pest's `$this->get(route(...))` handles URL generation correctly.
