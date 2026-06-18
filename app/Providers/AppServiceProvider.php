<?php

namespace App\Providers;

use App\Models\JobOffer;
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
    }
}
