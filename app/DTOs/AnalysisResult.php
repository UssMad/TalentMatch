<?php

namespace App\DTOs;

class AnalysisResult
{
    public function __construct(
        public readonly array $matchedSkills,
        public readonly array $missingSkills,
        public readonly bool $yearsExperienceFit,
        public readonly array $strengths,
        public readonly array $weaknesses,
        public readonly string $summary,
        public readonly string $recommendationReasoning,
        public readonly int $matchingScore,
        public readonly string $recommendation,
    ) {}

    public function toArray(): array
    {
        return [
            'matched_skills' => $this->matchedSkills,
            'missing_skills' => $this->missingSkills,
            'years_experience_fit' => $this->yearsExperienceFit,
            'strengths' => $this->strengths,
            'weaknesses' => $this->weaknesses,
            'summary' => $this->summary,
            'recommendation_reasoning' => $this->recommendationReasoning,
        ];
    }
}
