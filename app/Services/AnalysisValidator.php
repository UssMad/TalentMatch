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

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function validateRequiredFields(array $data): void
    {
        $required = ['matched_skills', 'missing_skills', 'years_experience_fit', 'strengths', 'weaknesses', 'summary', 'recommendation_reasoning', 'matching_score', 'recommendation'];

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
        foreach (['matched_skills', 'missing_skills', 'strengths', 'weaknesses'] as $field) {
            if (! isset($data[$field])) {
                continue;
            }

            if (! is_array($data[$field])) {
                $this->errors[] = "{$field} must be an array";
            }
        }
    }
}
