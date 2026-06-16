## 1. Form Requests

- [x] 1.1 Create `StoreCandidateRequest` with validation rules (name required|string|max:255, email required|email, phone nullable|string|max:20, cv_text required|string, job_offer_id required|exists:job_offers,id)
- [x] 1.2 Create `UpdateCandidateRequest` with same validation rules

## 2. Service

- [x] 2.1 Create `CandidateService` with methods: `list(JobOffer)`, `create(array)`, `find(Candidate)`, `update(Candidate, array)`, `delete(Candidate)`

## 3. Controller

- [x] 3.1 Create `CandidateController` with methods: index, create, store, show, edit, update, destroy — delegating to `CandidateService`
- [x] 3.2 Add ownership authorization check via parent job offer (return 403 if not owner)

## 4. Routes

- [x] 4.1 Add nested resource route `Route::resource('job-offers.candidates', CandidateController::class)` inside auth middleware

## 5. Views

- [x] 5.1 Create `index.blade.php` — list of candidates for a job offer
- [x] 5.2 Create `create.blade.php` — form with name, email, phone, cv_text
- [x] 5.3 Create `show.blade.php` — single candidate details with CV text
- [x] 5.4 Create `edit.blade.php` — pre-filled form to update

## 6. Job Offer View Updates

- [x] 6.1 Add "View Candidates" link to `job-offers/show.blade.php`
- [x] 6.2 Update candidate count display in `job-offers/show.blade.php` and `job-offers/index.blade.php`
