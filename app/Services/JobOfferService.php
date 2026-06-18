<?php

namespace App\Services;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class JobOfferService
{
    public function list(User $user): Collection
    {
        return $user->jobOffers()->latest()->get();
    }

    public function create(array $data): JobOffer
    {
        return JobOffer::create($data);
    }

    public function find(JobOffer $jobOffer): JobOffer
    {
        return $jobOffer->loadMissing('candidates', 'analyses');
    }

    public function update(JobOffer $jobOffer, array $data): JobOffer
    {
        $jobOffer->update($data);

        return $jobOffer;
    }

    public function delete(JobOffer $jobOffer): void
    {
        $jobOffer->delete();
    }
}
