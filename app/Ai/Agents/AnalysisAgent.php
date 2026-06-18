<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;

class AnalysisAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): string
    {
        return 'You are an expert recruitment analyst. Analyze the candidate CV against the job offer requirements and return structured analysis data.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'extracted_skills' => $schema->array()
                ->items($schema->string())
                ->description('All skills identified in the CV')
                ->required(),

            'years_of_experience' => $schema->integer()
                ->min(0)
                ->description('Total years of professional experience')
                ->required(),

            'education_level' => $schema->string()
                ->description('Highest education level (e.g., Bachelor\'s, Master\'s, PhD)')
                ->required(),

            'languages' => $schema->array()
                ->items($schema->string())
                ->description('Languages the candidate speaks')
                ->required(),

            'matching_score' => $schema->integer()
                ->min(0)
                ->max(100)
                ->description('Fit score between CV and job requirements (0-100)')
                ->required(),

            'strengths' => $schema->array()
                ->items($schema->string())
                ->description('Key strengths identified in the CV')
                ->required(),

            'weaknesses' => $schema->array()
                ->items($schema->string())
                ->description('Potential gaps or concerns')
                ->required(),

            'missing_skills' => $schema->array()
                ->items($schema->string())
                ->description('Required skills not found in CV')
                ->required(),

            'recommendation' => $schema->string()
                ->enum(['convoquer', 'attente', 'rejeter'])
                ->description('Recruitment decision: convoquer (invite), attente (hold), rejeter (reject)')
                ->required(),

            'justification' => $schema->string()
                ->description('Explanation for the recommendation')
                ->required(),
        ];
    }
}
