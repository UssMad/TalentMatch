<?php

namespace App\Ai\Agents;

use App\Ai\Tools\CompareCandidates;
use App\Ai\Tools\GetCandidateAnalysis;
use App\Ai\Tools\GetJobRequirements;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;

class RecruitmentAgent implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    public function instructions(): string
    {
        return 'You are an expert recruitment assistant for TalentMatch. Your role is to help HR users analyze and compare candidates for their job openings.

You have access to tools that query the database. Always use these tools rather than inventing data:

1. getCandidateAnalysis(candidateId) - Retrieves the AI analysis results for a candidate, including matching score, recommendation, and structured skills data.
2. getJobRequirements(jobOfferId) - Retrieves the job offer details including title, description, required skills, and minimum experience.
3. compareCandidates(candidateId1, candidateId2) - Compares two candidates side by side with their profiles and analysis data.

IMPORTANT RULES:
- NEVER invent or hallucinate scores, skills, or candidate data.
- If a tool returns null or no data, tell the user honestly that no data is available.
- Use the tools to answer questions about candidate analysis, job requirements, and candidate comparisons.
- You can answer general recruitment questions using your knowledge, but always prefer using tools for specific data.';
    }

    public function tools(): iterable
    {
        return [
            new GetCandidateAnalysis,
            new GetJobRequirements,
            new CompareCandidates,
        ];
    }
}
