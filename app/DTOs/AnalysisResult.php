<?php

namespace App\DTOs;

class AnalysisResult
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

    public static function fromAnalysisData(AnalysisData $data): self
    {
        return new self(
            extractedSkills: $data->extractedSkills,
            yearsOfExperience: $data->yearsOfExperience,
            educationLevel: $data->educationLevel,
            languages: $data->languages,
            matchingScore: $data->matchingScore,
            strengths: $data->strengths,
            weaknesses: $data->weaknesses,
            missingSkills: $data->missingSkills,
            recommendation: $data->recommendation,
            justification: $data->justification,
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
