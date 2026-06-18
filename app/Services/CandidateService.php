<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Collection;

class CandidateService
{
    public function list(JobOffer $jobOffer): Collection
    {
        return $jobOffer->candidates()->latest()->get();
    }

    public function create(array $data): Candidate
    {
        return Candidate::create($data);
    }

    public function find(Candidate $candidate): Candidate
    {
        return $candidate->loadMissing('analyses', 'conversations');
    }

    public function update(Candidate $candidate, array $data): Candidate
    {
        $candidate->update($data);

        return $candidate;
    }

    public function delete(Candidate $candidate): void
    {
        $candidate->delete();
    }
}
