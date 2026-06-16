<?php

namespace App\Services;

use App\DTOs\AnalysisResult;
use App\Models\Candidate;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Log;

class AIAnalysisService
{
    public function __construct(
        private readonly AnalysisPrompt $prompt,
        private readonly AnalysisValidator $validator,
    ) {}

    public function analyze(Candidate $candidate, JobOffer $jobOffer): ?AnalysisResult
    {
        $prompt = $this->prompt->build($candidate, $jobOffer);

        $response = $this->callLlm($prompt);

        if ($response === null) {
            Log::error('AI Analysis: LLM returned null response', [
                'candidate_id' => $candidate->id,
                'job_offer_id' => $jobOffer->id,
            ]);

            return null;
        }

        $data = $this->parseResponse($response);

        if ($data === null) {
            Log::error('AI Analysis: Failed to parse LLM response as JSON', [
                'candidate_id' => $candidate->id,
                'job_offer_id' => $jobOffer->id,
                'raw_response' => $response,
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

        return new AnalysisResult(
            matchedSkills: $data['matched_skills'],
            missingSkills: $data['missing_skills'],
            yearsExperienceFit: $data['years_experience_fit'],
            strengths: $data['strengths'],
            weaknesses: $data['weaknesses'],
            summary: $data['summary'],
            recommendationReasoning: $data['recommendation_reasoning'],
            matchingScore: $data['matching_score'],
            recommendation: $data['recommendation'],
        );
    }

    private function callLlm(string $prompt): ?string
    {
        try {
            $result = \AI::chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            return $result->choices[0]->message->content ?? null;
        } catch (\Exception $e) {
            Log::error('AI Analysis: LLM call failed', [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    private function parseResponse(string $response): ?array
    {
        $cleaned = trim($response);

        if (preg_match('/```(?:json)?\s*([\s\S]*?)```/', $cleaned, $matches)) {
            $cleaned = trim($matches[1]);
        }

        $data = json_decode($cleaned, true);

        return is_array($data) ? $data : null;
    }
}
