<?php

namespace App\DTOs;

class AnalysisData
{
    public function __construct(
        public readonly array $extractedSkills,
        public readonly int $yearsOfExperience,
        public readonly string $educationLevel,
        public readonly array $languages,
        public readonly int $matchingScore,
        public readonly array $strengths,
        public readonly array $weaknesses,
        public readonly array $missingSkills,
        public readonly string $recommendation,
        public readonly string $justification,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            extractedSkills: $data['extracted_skills'] ?? [],
            yearsOfExperience: (int) ($data['years_of_experience'] ?? 0),
            educationLevel: $data['education_level'] ?? '',
            languages: $data['languages'] ?? [],
            matchingScore: (int) ($data['matching_score'] ?? 0),
            strengths: $data['strengths'] ?? [],
            weaknesses: $data['weaknesses'] ?? [],
            missingSkills: $data['missing_skills'] ?? [],
            recommendation: $data['recommendation'] ?? '',
            justification: $data['justification'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'extracted_skills' => $this->extractedSkills,
            'years_of_experience' => $this->yearsOfExperience,
            'education_level' => $this->educationLevel,
            'languages' => $this->languages,
            'matching_score' => $this->matchingScore,
            'strengths' => $this->strengths,
            'weaknesses' => $this->weaknesses,
            'missing_skills' => $this->missingSkills,
            'recommendation' => $this->recommendation,
            'justification' => $this->justification,
        ];
    }
}
