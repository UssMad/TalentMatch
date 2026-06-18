<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\JobOffer;

class AnalysisPrompt
{
    public function build(Candidate $candidate, JobOffer $jobOffer): string
    {
        return <<<PROMPT
You are an expert recruitment analyst. Analyze the following candidate's CV against the job offer requirements.

Return ONLY valid JSON with NO markdown formatting, NO code fences, and NO additional text. The JSON must use exactly this structure:
{
    "extracted_skills": ["skill1", "skill2"],
    "years_of_experience": integer,
    "education_level": "Bachelor's, Master's, PhD, etc.",
    "languages": ["English", "French"],
    "matching_score": integer between 0 and 100,
    "strengths": ["strength1", "strength2"],
    "weaknesses": ["weakness1", "weakness2"],
    "missing_skills": ["skill1", "skill2"],
    "recommendation": "convoquer" or "attente" or "rejeter",
    "justification": "Explanation for the recommendation"
}

JOB OFFER:
Title: {$jobOffer->title}
Description: {$jobOffer->description}
Required Skills: {$jobOffer->required_skills}
Minimum Experience: {$jobOffer->min_experience} years

CANDIDATE CV:
{$candidate->cv_text}

Analyze thoroughly and return only the JSON object.
PROMPT;
    }
}
