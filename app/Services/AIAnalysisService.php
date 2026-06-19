<?php

namespace App\Services;

use App\Ai\Agents\AnalysisAgent;
use App\DTOs\AnalysisData;
use App\DTOs\AnalysisResult;
use App\Models\Candidate;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Log;

class AIAnalysisService
{
    public function __construct(
        private readonly AnalysisValidator $validator,
    ) {}

    public function analyze(Candidate $candidate, JobOffer $jobOffer): ?AnalysisResult
    {
        try {
            $agent = new AnalysisAgent;

            $skills = is_array($jobOffer->required_skills)
                ? implode(', ', $jobOffer->required_skills)
                : $jobOffer->required_skills;

            $context = <<<CONTEXT
JOB OFFER:
Title: {$jobOffer->title}
Description: {$jobOffer->description}
Required Skills: {$skills}
Minimum Experience: {$jobOffer->min_experience} years

CANDIDATE CV:
{$candidate->cv_text}
CONTEXT;

            $response = $agent->prompt($context);

            $data = $response instanceof AnalysisData
                ? $response->toArray()
                : $response->toArray();
        } catch (\Exception $e) {
            Log::error('AI Analysis: Agent call failed', [
                'candidate_id' => $candidate->id,
                'job_offer_id' => $jobOffer->id,
                'error' => $e->getMessage(),
            ]);

            return null;
        }

        if (! $this->validator->validate($data)) {
            Log::warning('AI Analysis: Validation failed', [
                'candidate_id' => $candidate->id,
                'job_offer_id' => $jobOffer->id,
                'errors' => $this->validator->getErrors(),
                'data' => $data,
            ]);

            return null;
        }

        return AnalysisResult::fromAnalysisData(
            AnalysisData::fromArray($data)
        );
    }
}
