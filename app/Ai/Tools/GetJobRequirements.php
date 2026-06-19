<?php

namespace App\Ai\Tools;

use App\Models\JobOffer;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetJobRequirements implements Tool
{
    public function name(): string
    {
        return 'getJobRequirements';
    }

    public function description(): Stringable|string
    {
        return 'Retrieve the job requirements for a job offer by job offer ID. Returns title, description, required skills, minimum experience, or null if not found.';
    }

    public function handle(Request $request): Stringable|string
    {
        $jobOffer = JobOffer::find($request['jobOfferId']);

        if (! $jobOffer) {
            return json_encode(['job_offer' => null]);
        }

        return json_encode([
            'job_offer' => [
                'title' => $jobOffer->title,
                'description' => $jobOffer->description,
                'required_skills' => $jobOffer->required_skills,
                'min_experience' => $jobOffer->min_experience,
            ],
        ]);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'jobOfferId' => $schema->integer()
                ->description('The ID of the job offer to retrieve requirements for')
                ->required(),
        ];
    }
}
