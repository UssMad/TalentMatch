## 1. Enum & DTO Changes

- [x] 1.1 Update `App\Enums\Recommendation` to use `convoquer`, `attente`, `rejeter` cases
- [x] 1.2 Create `App\DTOs\AnalysisData` DTO for Laravel AI structured output with all new contract fields
- [x] 1.3 Update `App\DTOs\AnalysisResult` constructor and `toArray()` to match the new contract

## 2. Service Layer Updates

- [x] 2.1 Update `AnalysisPrompt::build()` to request the new JSON contract (extracted_skills, years_of_experience, education_level, languages, justification)
- [x] 2.2 Update `AnalysisValidator` to validate the new contract fields and new enum values
- [x] 2.3 Update `AIAnalysisService::analyze()` to use Laravel AI structured output with the `AnalysisData` DTO
- [x] 2.4 Create `AnalysisAgent` with `HasStructuredOutput` and remove deprecated `callLlm()`/`parseResponse()`

## 3. Database Migration

- [x] 3.1 Create a migration to add/remove columns in `analyses` table (if needed beyond `structured_data` JSON)
- [x] 3.2 Handle existing records with old enum values (convert or mark for re-analysis)

## 4. Auto-Dispatch on CV Submission

- [x] 4.1 Add model events on `Candidate` (creating/updating) to auto-dispatch `RunAnalysisJob` when `cv_text` is present
- [x] 4.2 Ensure auto-dispatch only triggers when `cv_text` changes (avoid duplicate jobs on non-CV updates)

## 5. Tests

- [x] 5.1 Create tests for `Recommendation` enum to use new values
- [x] 5.2 Create tests for `AnalysisValidator` to cover new contract fields
- [x] 5.3 Create tests for new `AnalysisData` DTO
- [x] 5.4 Create tests for auto-dispatch on candidate create/update
- [x] 5.5 Run full test suite and fix any regressions

## 6. Final Quality

- [x] 6.1 Run `vendor/bin/pint` to format all modified PHP files
- [x] 6.2 Run `php artisan test --compact` to verify all tests pass
