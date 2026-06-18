<?php

namespace App\Jobs;

use App\Models\Analysis;
use App\Models\Candidate;
use App\Models\JobOffer;
use App\Services\AIAnalysisService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class RunAnalysisJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public readonly int $candidateId,
        public readonly int $jobOfferId,
    ) {}

    public function handle(AIAnalysisService $analysisService): void
    {
        $candidate = Candidate::find($this->candidateId);
        $jobOffer = JobOffer::find($this->jobOfferId);

        if (! $candidate || ! $jobOffer) {
            Log::error('RunAnalysisJob: Candidate or JobOffer not found', [
                'candidate_id' => $this->candidateId,
                'job_offer_id' => $this->jobOfferId,
            ]);

            return;
        }

        $result = $analysisService->analyze($candidate, $jobOffer);

        $existingAnalysis = Analysis::where('candidate_id', $this->candidateId)
            ->where('job_offer_id', $this->jobOfferId)
            ->first();

        if ($result !== null) {
            $data = [
                'candidate_id' => $this->candidateId,
                'job_offer_id' => $this->jobOfferId,
                'structured_data' => $result->toArray(),
                'matching_score' => $result->matchingScore,
                'recommendation' => $result->recommendation,
            ];

            if ($existingAnalysis) {
                $existingAnalysis->update($data);
            } else {
                Analysis::create($data);
            }
        } else {
            if ($existingAnalysis) {
                $existingAnalysis->update([
                    'raw_ai_response' => ['error' => 'Analysis failed - see logs'],
                ]);
            } else {
                Analysis::create([
                    'candidate_id' => $this->candidateId,
                    'job_offer_id' => $this->jobOfferId,
                    'structured_data' => null,
                    'matching_score' => 0,
                    'recommendation' => 'attente',
                    'raw_ai_response' => ['error' => 'Analysis failed - see logs'],
                ]);
            }
        }
    }
}
