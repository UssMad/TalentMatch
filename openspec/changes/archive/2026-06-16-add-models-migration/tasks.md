## 1. Enum

- [x] 1.1 Create `app/Enums/Recommendation.php` backed string enum with values: Strongly Recommend, Recommend, Consider, Not Recommended, No Decision

## 2. Migrations

- [x] 2.1 Create migration to add `job_offer_id` (FK -> job_offers, cascade), `name`, `email`, `phone`, `cv_text` (longText), `cv_file_path` (nullable) to `candidates` table
- [x] 2.2 Create migration to add `candidate_id` (FK -> candidates, cascade), `job_offer_id` (FK -> job_offers, cascade), `structured_data` (JSON), `matching_score` (integer), `recommendation` (string), `raw_ai_response` (JSON nullable) to `analyses` table
- [x] 2.3 Create migration to add `candidate_id` (FK -> candidates, nullable), `user_id` (FK -> users, cascade), `title` (string), `context` (JSON nullable) to `conversations` table
- [x] 2.4 Create migration to add `conversation_id` (FK -> conversations, cascade), `role` (string), `content` (longText), `tool_calls` (JSON nullable) to `messages` table

## 3. Models

- [x] 3.1 Update `Candidate` model with `$fillable`, `$casts`, and relationships: `belongsTo(JobOffer)`, `hasMany(Analysis)`, `hasMany(Conversation)`
- [x] 3.2 Update `Analysis` model with `$fillable`, `$casts`, `belongsTo(Candidate)`, `belongsTo(JobOffer)`, and `Recommendation` enum casting for `recommendation`
- [x] 3.3 Update `Conversation` model with `$fillable`, `$casts`, `belongsTo(User)`, `belongsTo(Candidate)`, `hasMany(Message)`
- [x] 3.4 Update `Message` model with `$fillable`, `$casts`, `belongsTo(Conversation)`

## 4. Verification

- [x] 4.1 Run `php artisan migrate` to apply all new migrations
- [x] 4.2 Run `php artisan migrate:rollback` and `php artisan migrate` to verify rollback works
- [x] 4.3 Verify all model relationships work via `php artisan tinker` or test
