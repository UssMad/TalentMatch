<?php

namespace App\Policies;

use App\Models\Candidate;
use App\Models\JobOffer;
use App\Models\User;

class CandidatePolicy
{
    public function viewAny(User $user, JobOffer $jobOffer): bool
    {
        return $jobOffer->user_id === $user->id;
    }

    public function view(User $user, Candidate $candidate): bool
    {
        return $candidate->jobOffer->user_id === $user->id;
    }

    public function create(User $user, JobOffer $jobOffer): bool
    {
        return $jobOffer->user_id === $user->id;
    }

    public function update(User $user, Candidate $candidate): bool
    {
        return $candidate->jobOffer->user_id === $user->id;
    }

    public function delete(User $user, Candidate $candidate): bool
    {
        return $candidate->jobOffer->user_id === $user->id;
    }
}
