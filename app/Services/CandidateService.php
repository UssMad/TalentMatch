<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CandidateService
{
    public function list(JobOffer $jobOffer): Collection
    {
        return $jobOffer->candidates()->latest()->get();
    }

    public function listAll(): LengthAwarePaginator
    {
        return Candidate::with('jobOffer', 'analyses')
            ->latest()
            ->paginate(20);
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
