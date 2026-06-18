<?php

namespace App\Policies;

use App\Models\JobOffer;
use App\Models\User;

class JobOfferPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, JobOffer $jobOffer): bool
    {
        return $jobOffer->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, JobOffer $jobOffer): bool
    {
        return $jobOffer->user_id === $user->id;
    }

    public function delete(User $user, JobOffer $jobOffer): bool
    {
        return $jobOffer->user_id === $user->id;
    }

    public function modify(User $user, JobOffer $jobOffer): bool
    {
        return $jobOffer->user_id === $user->id;
    }
}
