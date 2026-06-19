<?php

namespace App\Providers;

use App\Models\Candidate;
use App\Models\JobOffer;
use App\Policies\CandidatePolicy;
use App\Policies\JobOfferPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(JobOffer::class, JobOfferPolicy::class);
        Gate::policy(Candidate::class, CandidatePolicy::class);
    }
}
