<?php

namespace App\Ai\Tools;

use App\Models\Candidate;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CompareCandidates implements Tool
{
    public function name(): string
    {
        return 'compareCandidates';
    }

    public function description(): Stringable|string
    {
        return 'Compare two candidates by their IDs. Returns a comparison of their profiles, analysis scores, skills, and recommendations.';
    }

    public function handle(Request $request): Stringable|string
    {
        $candidate1 = Candidate::with('analyses')->find($request['candidateId1']);
        $candidate2 = Candidate::with('analyses')->find($request['candidateId2']);

        if (! $candidate1 && ! $candidate2) {
            return json_encode(['error' => 'Neither candidate was found.']);
        }

        $formatCandidate = function (?Candidate $candidate): ?array {
            if (! $candidate) {
                return null;
            }

            $latestAnalysis = $candidate->analyses->sortByDesc('created_at')->first();

            return [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'email' => $candidate->email,
                'analysis' => $latestAnalysis ? [
                    'matching_score' => $latestAnalysis->matching_score,
                    'recommendation' => $latestAnalysis->recommendation->value,
                    'structured_data' => $latestAnalysis->structured_data,
                ] : null,
            ];
        };

        return json_encode([
            'candidate1' => $formatCandidate($candidate1),
            'candidate2' => $formatCandidate($candidate2),
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'candidateId1' => $schema->integer()
                ->description('The ID of the first candidate to compare')
                ->required(),
            'candidateId2' => $schema->integer()
                ->description('The ID of the second candidate to compare')
                ->required(),
        ];
    }
}
