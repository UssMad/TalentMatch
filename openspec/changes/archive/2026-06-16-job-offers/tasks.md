## 1. Model

- [x] 1.1 Add `analyses()` hasMany relationship to `JobOffer` model

## 2. Form Requests

- [x] 2.1 Create `StoreJobOfferRequest` with validation rules (title required|string|max:255, description required|string, required_skills required|array|min:1, required_skills.* string, min_experience required|integer|min:0)
- [x] 2.2 Create `UpdateJobOfferRequest` with same validation rules

## 3. Service

- [x] 3.1 Create `JobOfferService` with methods: `list(User)`, `create(array)`, `find(JobOffer)`, `update(JobOffer, array)`, `delete(JobOffer)`

## 4. Controller

- [x] 4.1 Create `JobOfferController` with thin methods: index, create, store, show, edit, update, destroy — delegating to `JobOfferService`
- [x] 4.2 Add ownership authorization check in edit, update, destroy (return 403 if not owner)

## 5. Routes

- [x] 5.1 Add `Route::resource('job-offers', JobOfferController::class)->middleware('auth')` to `web.php`

## 6. Views

- [x] 6.1 Create `index.blade.php` — list of job offers with create button
- [x] 6.2 Create `create.blade.php` — form with title, description, required_skills (dynamic add/remove), min_experience
- [x] 6.3 Create `show.blade.php` — single job offer details
- [x] 6.4 Create `edit.blade.php` — pre-filled form to update

## 7. Navigation

- [x] 7.1 Add "Job Offers" navigation link to `layouts/navigation.blade.php`
