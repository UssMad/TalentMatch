<?php

namespace App\Ai\Tools;

use App\Models\Analysis;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetCandidateAnalysis implements Tool
{
    public function description(): Stringable|string
    {
        return 'Retrieve the AI analysis results for a candidate by candidate ID. Returns matching score, recommendation, structured data, or null if no analysis exists.';
    }

    public function handle(Request $request): Stringable|string
    {
        $analysis = Analysis::where('candidate_id', $request->candidateId)
            ->latest()
            ->first();

        if (! $analysis) {
            return json_encode(['analysis' => null]);
        }

        return json_encode([
            'analysis' => [
                'matching_score' => $analysis->matching_score,
                'recommendation' => $analysis->recommendation->value,
                'structured_data' => $analysis->structured_data,
                'created_at' => $analysis->created_at->toDateTimeString(),
            ],
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'candidateId' => $schema->integer()
                ->description('The ID of the candidate to retrieve analysis for')
                ->required(),
        ];
    }
}
