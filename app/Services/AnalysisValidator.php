<?php

namespace App\Services;

use App\Enums\Recommendation;

class AnalysisValidator
{
    private array $errors = [];

    public function validate(array $data): bool
    {
        $this->errors = [];

        $this->validateRequiredFields($data);
        $this->validateMatchingScore($data);
        $this->validateRecommendation($data);
        $this->validateArrays($data);
        $this->validateYearsOfExperience($data);
        $this->validateEducationLevel($data);
        $this->validateJustification($data);

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function validateRequiredFields(array $data): void
    {
        $required = ['extracted_skills', 'years_of_experience', 'education_level', 'languages', 'matching_score', 'strengths', 'weaknesses', 'missing_skills', 'recommendation', 'justification'];

        foreach ($required as $field) {
            if (! array_key_exists($field, $data)) {
                $this->errors[] = "Missing required field: {$field}";
            }
        }
    }

    private function validateMatchingScore(array $data): void
    {
        if (! isset($data['matching_score'])) {
            return;
        }

        if (! is_int($data['matching_score']) || $data['matching_score'] < 0 || $data['matching_score'] > 100) {
            $this->errors[] = 'matching_score must be an integer between 0 and 100';
        }
    }

    private function validateRecommendation(array $data): void
    {
        if (! isset($data['recommendation'])) {
            return;
        }

        $valid = array_map(fn (Recommendation $case) => $case->value, Recommendation::cases());

        if (! in_array($data['recommendation'], $valid, true)) {
            $this->errors[] = 'recommendation must be one of: '.implode(', ', $valid);
        }
    }

    private function validateArrays(array $data): void
    {
        foreach (['extracted_skills', 'languages', 'strengths', 'weaknesses', 'missing_skills'] as $field) {
            if (! isset($data[$field])) {
                continue;
            }

            if (! is_array($data[$field])) {
                $this->errors[] = "{$field} must be an array";
            }
        }
    }

    private function validateYearsOfExperience(array $data): void
    {
        if (! isset($data['years_of_experience'])) {
            return;
        }

        if (! is_int($data['years_of_experience']) || $data['years_of_experience'] < 0) {
            $this->errors[] = 'years_of_experience must be a non-negative integer';
        }
    }

    private function validateEducationLevel(array $data): void
    {
        if (! isset($data['education_level'])) {
            return;
        }

        if (! is_string($data['education_level']) || trim($data['education_level']) === '') {
            $this->errors[] = 'education_level must be a non-empty string';
        }
    }

    private function validateJustification(array $data): void
    {
        if (! isset($data['justification'])) {
            return;
        }

        if (! is_string($data['justification']) || trim($data['justification']) === '') {
            $this->errors[] = 'justification must be a non-empty string';
        }
    }
}
